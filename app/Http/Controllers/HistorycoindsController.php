<?php

namespace App\Http\Controllers;

use App\Exports\DepoWdExport;
use App\Models\DepoWd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HistorycoindsController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->filterAndPaginate(20);
        $dataagent = User::pluck('username');

        $currentDate = now();
        $tgldari = $request->input('tgldari', $currentDate->copy()->subDays(30)->format('Y-m-d'));
        $tglsampai = $request->input('tglsampai', $currentDate->format('Y-m-d'));

        return view('historycoinds.index', [
            'title' => 'List History',
            'data' => $data,
            'dataagent' => $dataagent,
            'tgldari' => $tgldari,
            'tglsampai' => $tglsampai,
            'is_old' => false
        ]);
    }

    public function index_old(Request $request)
    {
        $paginatedData = $this->filterAndPaginateOld(20, $request);
        $dataagent = User::pluck('username');

        $currentDate = now();
        $tgldari = $request->input('tgldari', $currentDate->copy()->subMonth()->startOfMonth()->format('Y-m-d'));
        $tglsampai = $request->input('tglsampai', $currentDate->copy()->subMonth()->endOfMonth()->format('Y-m-d'));

        return view('historycoinds.index', [
            'title' => 'List History',
            'data' => $paginatedData,
            'dataagent' => $dataagent,
            'tgldari' => $tgldari,
            'tglsampai' => $tglsampai,
            'is_old' => true
        ]);
    }

    private function getOldData($tgldari, $tglsampai)
    {
        $dates = [];

        // Loop untuk setiap bulan dalam rentang waktu
        while ($tgldari->lessThanOrEqualTo($tglsampai)) {
            // Tentukan bulan dan tahun
            $bulan = $tgldari->format('m');
            $tahun = $tgldari->format('Y');

            // Tentukan tgldari dan tglsampai untuk bulan ini
            $bulanTgldari = $tgldari->copy();
            $bulanTglsampai = $tgldari->copy()->endOfMonth();

            // Jika tglsampai melebihi tglsampai, batasi ke tglsampai
            if ($bulanTglsampai->greaterThan($tglsampai)) {
                $bulanTglsampai = $tglsampai;
            }

            // Tambahkan hasil ke array
            $dates[] = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tgldari' => $bulanTgldari->toDateString(),
                'tglsampai' => $bulanTglsampai->toDateString(),
            ];

            // Pindah ke bulan berikutnya
            $tgldari->addMonth()->startOfMonth();
        }

        $allData = collect();

        foreach ($dates as $date) {
            $response = Http::withHeaders([
                'utilitiesgenerate' => '2957984855aa91f9b11c2528bc389c97212348b9d211570911b621a285bba1aa417b0a98d78e42a2b764441795d403caf059b035ac0e2c58ba8099ff3bbac354',
                'Accept' => 'application/json'
            ])->get(env('OLDDOMAIN') . 'api/olddata/historycoins', [
                'tgldari' => $date['tgldari'],
                'tglsampai' => $date['tglsampai'],
                'bulan' => $date['bulan'],
                'tahun' => $date['tahun']
            ]);

            // Decode and collect each response
            $data = json_decode($response->body(), false);
            $allData = $allData->concat(collect($data));
        }

        return $allData;
    }

    public function filterAndPaginateOld($page, $request)
    {
        $tgldari = Carbon::parse($request->tgldari);
        $tglsampai = Carbon::parse($request->tglsampai);

        $data = $this->getOldData($tgldari, $tglsampai);

        if (is_null($data)) {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }

        $reqs = request()->all();
        $jenis = isset($reqs['jenis']) ? $reqs['jenis'] : '';
        $username = isset($reqs['username']) ? $reqs['username'] : '';
        $status = isset($reqs['status']) ? $reqs['status'] : '';
        $approved_by = isset($reqs['approved_by']) ? $reqs['approved_by'] : '';

        if (request('tgldari') && request('tglsampai')) {
            $tgldari = request('tgldari') . " 00:00:00";
            $tglsampai = request('tglsampai') . " 23:59:59";
        } else {
            $tgldari = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $tglsampai = date('Y-m-d 00:00:00');
        }

        if ($jenis) {
            $data = $data->filter(function ($item) use ($jenis) {
                if ($jenis == 'M') {
                    return in_array($item->jenis, ['DPM', 'WDM']);
                } else {
                    return $item->jenis == $jenis;
                }
            });
        }

        if ($username) {
            $data = $data->filter(function ($item) use ($username) {
                return stripos($item->username, $username) !== false;
            });
        }

        if ($status == 'accept') {
            $data = $data->filter(function ($item) use ($status) {
                return $item->status == 1;
            });
        } else if ($status == 'cancel') {
            $data = $data->filter(function ($item) use ($status) {
                return $item->status == 2;
            });
        }

        if ($approved_by) {
            $data = $data->filter(function ($item) use ($approved_by) {
                return $item->approved_by == $approved_by;
            });
        }

        // dd($data->toArray());
        if ($tgldari && $tglsampai) {
            $data = $data->filter(function ($item) use ($tgldari, $tglsampai) {
                $createdAt = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                return Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->between($tgldari, $tglsampai);
            });
        }

        // Format ulang tanggal jika diperlukan
        $data = $data->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
            $item->updated_at = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            return $item;
        });


        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $currentPageData = $data->slice(($currentPage - 1) * $page, $page)->values();
        $paginatedData = new LengthAwarePaginator(
            $currentPageData,
            $data->count(),
            $page,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        foreach ($reqs as $key => $value) {
            if (!is_null($value)) {
                $paginatedData->appends($key, $value);
            }
        }

        return $paginatedData;
    }

    public function filterAndPaginate($page)
    {
        $query = DepoWD::query()
            ->select(
                '*',
                DB::raw("CASE jenis
                WHEN 'DP' THEN 'deposit'
                WHEN 'WD' THEN 'withdraw'
                WHEN 'DPM' THEN 'deposit manual'
                WHEN 'WDM' THEN 'withdraw manual'
                ELSE jenis
            END as jenis_temp")
            );

        $query->whereIn('status', [1, 2]);

        $parameter = [
            'username',
            'approved_by',
        ];
        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $query->where($isiSearch, 'like', '%' . request($isiSearch) . '%');
            }
        }

        // Filter status unique
        if (request('status') == "accept") {
            $query->where('status', 1);
        } elseif (request('status') == "cancel") {
            $query->where('status', 2);
        }
        // dd($query->toSql());

        // Filter berdasarkan jenis
        if (request('jenis') === 'DP') {
            $query->where('jenis', 'DP');
        } elseif (request('jenis') === "WD") {
            $query->where('jenis', 'WD');
        } elseif (request('jenis') === "M") {
            $query->whereIn('jenis', ['DPM', 'WDM']);
        }

        // Tambahan Filter Tanggal
        if (request('tgldari') && request('tglsampai')) {
            $tgldari = request('tgldari') . " 00:00:00";
            $tglsampai = request('tglsampai') . " 23:59:59";
            $query->whereBetween('created_at', [$tgldari, $tglsampai]);
        } else {
            // $tgldari = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            // $tglsampai = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            $tgldari = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))) . " 00:00:00";
            $tglsampai = date('Y-m-d') . " 23:59:59";
            $query->whereBetween('created_at', [$tgldari, $tglsampai]);
        }

        $query->orderByDesc('created_at');

        if ($page > 0) {
            $paginatedItems = $query->paginate($page)->appends(request()->except('page'));
        } else {
            $paginatedItems = $query->get();
        }

        // Post-process to replace 'jenis' with 'jenis_temp'
        $paginatedItems->getCollection()->transform(function ($item) {
            $item->jenis = $item->jenis_temp;
            unset($item->jenis_temp);
            return $item;
        });

        return $paginatedItems;
    }

    public function export(Request $request)
    {
        $is_old = $request->input('is_old');
        if ($is_old == "true") {
            $crot = $this->filterAndPaginateOld(9999999999999999, $request);
        } else {
            $crot = $this->filterAndPaginate(9999999999999999);
        }

        $data = $crot->getCollection();
        return Excel::download(new DepoWdExport($data), 'Historycoin.xlsx');
    }
}
