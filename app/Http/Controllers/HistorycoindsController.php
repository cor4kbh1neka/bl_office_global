<?php

namespace App\Http\Controllers;

use App\Exports\DepoWdExport;
use App\Models\DepoWd;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

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
        $query = DepoWD::query();

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
        }

        $query->orderByDesc('created_at');
        if ($page > 0) {
            $paginatedItems = $query->paginate($page)->appends(request()->except('page'));
        } else {
            $paginatedItems = $query->get();
        }
        return $paginatedItems;
    }

    public function export()
    {
        $data = $this->filterAndPaginate(0);
        return Excel::download(new DepoWdExport($data), 'Historycoin.xlsx');
    }
}
