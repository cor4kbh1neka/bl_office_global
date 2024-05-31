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
    public function index1(Request $request)
    {

        if ($request->query('search_status') == 'accept') {
            $status = 1;
        } else if ($request->query('search_status') == 'cancel') {
            $status = 2;
        } else {
            $status = '';
        }

        $username = $request->query('search_username');
        $jenis = $request->query('search_jenis');
        $agent = $request->query('search_agent');
        $tgldari = $request->query('tgldari') != '' ? date('Y-m-d 00:00:00', strtotime($request->query('tgldari'))) : date("Y-m-d 00:00:00");
        $tglsampai =  $request->query('tglsampai') != '' ?  date('Y-m-d 23:59:59', strtotime($request->query('tglsampai'))) : date("Y-m-d 23:59:59");
        dd($datHistory = DepoWd::whereIn('status', [1, 2]));
        $datHistory = DepoWd::whereIn('status', [1, 2])
            ->when($jenis, function ($query) use ($jenis) {
                if ($jenis === 'M') {
                    return $query->whereIn('jenis', ['DPM', 'WDM']);
                } else {
                    return $query->where('jenis', $jenis);
                }
            })
            ->when($username, function ($query) use ($username) {
                return $query->where('username', 'LIKE', '%' . $username . '%');
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($agent, function ($query) use ($agent) {
                return $query->where('approved_by', $agent);
            })
            ->when($tgldari && $tglsampai, function ($query) use ($tgldari, $tglsampai) {
                return $query->whereBetween('created_at', [$tgldari, $tglsampai]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // ->map(function ($item) {
        //     if ($item['jenis'] == 'DPM') {
        //         $item['jenis'] = 'Deposit Manual';
        //     } else if ($item['jenis'] == 'WDM') {
        //         $item['jenis'] = 'Withdraw Manual';
        //     } else if ($item['jenis'] == 'DP') {
        //         $item['jenis'] = 'Deposit';
        //     } else if ($item['jenis'] == 'WD') {
        //         $item['jenis'] = 'Withdraw';
        //     }

        //     return $item;
        // });


        return view('historycoinds.index', [
            'title' => 'List History',
            'data' => $datHistory,

            'totalnote' => 0,
            'search_jenis' => $jenis,
            'search_username' => $username,
            'search_status' => $status,
            'search_agent' => $agent,
            'tgldari' => $tgldari != '' ? date("Y-m-d", strtotime($tgldari)) : $tgldari,
            'tglsampai' => $tglsampai != '' ? date("Y-m-d", strtotime($tglsampai)) : $tglsampai,
        ]);
    }
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
