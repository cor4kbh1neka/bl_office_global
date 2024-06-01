<?php

namespace App\Http\Controllers;

use App\Exports\DepoWdExport;
use App\Models\DepoWd;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistorycoindsController extends Controller
{
    public function index()
    {
        $data = $this->filterAndPaginate(20);
        return view('historycoinds.index', [
            'title' => 'List History',
            'data' => $data,
        ]);
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
            $tgldari = Carbon::now()->format('Y-m-d') . " 00:00:00";
            $tglsampai = Carbon::now()->format('Y-m-d') . " 23:59:59";
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
        $hariIni = Carbon::now()->format('Y-m-d');
        $semingguYangLalu = Carbon::now()->subDays(7)->format('Y-m-d');

        $tgldari = $request->input('tgldari');
        $tglsampai = $request->input('tglsampai');

        if ($tgldari >= $semingguYangLalu && $tgldari <= $hariIni && $tglsampai >= $semingguYangLalu && $tglsampai <= $hariIni && $tgldari <= $tglsampai) {
            $crot = $this->filterAndPaginate(10);
            $data = $crot->getCollection();
            return Excel::download(new DepoWdExport($data), 'Historycoin.xlsx');
        } else {
            return redirect('historycoinds')->with('gagalTarikData', 'Harap masukkan rentang tanggal dalam 7 hari terakhir');
        }
    }
}
