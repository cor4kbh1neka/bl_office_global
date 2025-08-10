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

    private function getOldData($username, $status, $approved_by, $tgldari, $tglsampai, $page)
    {
        try {
            $parameters = [
                'tgldari' => $tgldari,
                'tglsampai' => $tglsampai
            ];
            
            if (!empty($page)) {
                $parameters['page'] = $page;
            }

            if (!empty($username)) {
                $parameters['username'] = $username;
            }
            
            if (!empty($status)) {
                $parameters['status'] = $status=='accept' ? 1 : 2;
            }

            if (!empty($approved_by)) {
                $parameters['approved_by'] = $approved_by;
            }
            
            $response = Http::withHeaders([
                'utilitiesgenerate' => env('UTILITIES_GENERATE_OLD'),
                'Accept' => 'application/json'
            ])->get(env('OLDDOMAIN') . 'api/olddata/historycoins', $parameters);
            
            $data =  $response->json();
            // dd($data);
        } catch (\Exception $e) {
            $data = [];
        }

        return $data;
    }

    public function filterAndPaginateOld($page, $request)
    {
        $username = $request->username;
        $status = $request->status;
        $approved_by = $request->approved_by;
        $tgldari = $request->has('tgldari') ? $request->tgldari : Carbon::now()->subDays(30)->toDateString();
        $tglsampai = $request->has('tglsampai') ? $request->tglsampai : Carbon::now()->toDateString();
        $page = $request->has('page') ? $request->page : 1;

        $data = $this->getOldData($username, $status, $approved_by, $tgldari, $tglsampai, $page);

        if (is_null($data) || !isset($data['data'])) {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }

        $dataItems = $this->arrayToObject(collect($data['data']));

        $currentPage = $data['current_page'] ?? 1;
        $total = $data['total'] ?? $dataItems->count();
        $perPage = $data['per_page'] ?? $page;

        $paginatedData = new LengthAwarePaginator(
            $dataItems,
            $total,
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $reqs = request()->all();
        foreach ($reqs as $key => $value) {
            if (!is_null($value)) {
                $paginatedData->appends($key, $value);
            }
        }
        return $paginatedData;
    }

    private function arrayToObject($data)
    {
        return json_decode(json_encode($data));
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
