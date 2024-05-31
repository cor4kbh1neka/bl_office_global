<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DepoWd;
use App\Models\Companys;
use App\Models\Settings;
use App\Models\Currencys;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HistoryTransaksi;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepoWdExport;


class HistorytransaksidsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->getQueryString() && request('username')) {
            $data = $this->filterAndPaginate(HistoryTransaksi::orderByDesc('created_at')->get(), 20);
        }
        return view('historytransaksids.index', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
        ]);
    }

    private function getApiBetList()
    {
        $data = [
            "username" => "abangpoorgas",
            "portfolio" => "SportsBook",
            "startDate" => "2024-04-01T00:00:00.540Z",
            "endDate" => "2024-05-30T23:59:59.540Z",
            "companyKey" => "C441C721B2214E658A6D2A72C41D2063",
            "language" => "en",
            "serverId" => "YY-TEST"
        ];
        $response = Http::withTokenHeader()->post('https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-modify-date.aspx', $data);

        return $response->json();
    }


    public function transaksilama(Request $request)
    {
        $query = $request->getQueryString();
        $username = $request->input('username');

        $checkinvoice = $request->input('checkinvoice');
        $invoice = $request->input('invoice');

        $checkstatus = $request->input('checkstatus');
        $status = $request->input('status');


        $checktransdari = $request->input('checktransdari');
        $transdari = $request->input('transdari') == null ? date('Y-m-01') . 'T00:00' : $request->input('transdari');


        $checktranshingga = $request->input('checktranshingga');
        $transhingga = $request->input('transhingga') == null ? date('Y-m-t') . 'T23:59' : $request->input('transhingga');

        if ($username != '') {
            $data = HistoryTransaksi::where('username', $username)
                ->when($checkinvoice == 'on' && $invoice != '', function ($query) use ($invoice) {
                    return $query->where('refno', $invoice);
                })
                ->when($checkstatus == 'on' && $status != '', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->when(($checktransdari == 'on' && $transdari != '') || ($checktranshingga == 'on' && $transhingga != ''), function ($query) use ($transdari, $transhingga) {
                    $tgldari = date('Y-m-d H:i:s', strtotime($transdari));
                    $tglsampai = date('Y-m-d H:i:s', strtotime($transhingga));
                    $tglsampai = substr_replace($tglsampai, '59', -2);

                    $query->whereBetween('created_at', [$tgldari, $tglsampai]);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = [];
        }

        return view('historytransaksids.transaksi_lama', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'totalnote' => 0,
            'total' => 0,
            'username' => $username,
            'checkinvoice' => $checkinvoice,
            'invoice' => $invoice,
            'checkstatus' => $checkstatus,
            'status' => $status,
            'checktransdari' => $checktransdari,
            'transdari' => $transdari,
            'checktranshingga' => $checktranshingga,
            'transhingga' => $transhingga,
            'query' => $query
        ]);
    }
    public function filterAndPaginate($data, $page) // Untuk beberapa kondisi pisahkan array dari parameter agar lolos $query
    {
        $query = collect($data);
        $parameter = [
            'status',
        ];

        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $query = $query->filter(function ($item) use ($isiSearch) {
                    return stripos($item[$isiSearch], request($isiSearch)) !== false;
                });
            }
        }

        // Filter untuk Tanggal, comment aja klau tidak terpakai :D
        if (request('transdari') && request('transhingga')) {
            $transdariInput = request('transdari');
            $transhinggaInput = request('transhingga');

            $transdari = Carbon::createFromFormat('Y-m-d\TH:i', $transdariInput)->format('Y-m-d H:i:s');
            $transhingga = Carbon::createFromFormat('Y-m-d\TH:i', $transhinggaInput)->format('Y-m-d H:i:s');

            $query = $query->whereBetween('created_at', [$transdari, $transhingga]);
        }
        // Filter untuk strict data
        if (request('username')) {
            $inputUsername = request('username');
            $query = $query->filter(function ($item) use ($inputUsername) {
                return $item['username'] === $inputUsername;
            });
        }
        if (request('invoice')) {
            $inputInvoice = request('invoice');
            $query = $query->filter(function ($item) use ($inputInvoice) {
                return stripos($item['invoice'], $inputInvoice) !== false;
            });
        }
        if (!request('checkall') || !request(['checkinvoice', 'checkstatus', 'checktransdari', 'checktranshingga'])) {
            return $query = [];
        }
        $parameter = array_merge($parameter, [
            'username',
            'invoice',
            'transdari',
            'transhingga',
            'checkinvoice',
            'checkstatus',
            'checktransdari',
            'checktranshingga',
            'checkall',
        ]); // $parameter dikembaliin lagi supaya paginator nya jalan okey?
        // Kalau bisa paginator ini jangan diubah, cukup sampai disini sajaa :(
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = $page;
        $currentPageItems = $query->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $query->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $paginatedItems->appends($isiSearch, request($isiSearch));
            }
        }
        return $paginatedItems;
    }

    // public function export()
    // {
    //     $data = $this->filterAndPaginate(HistoryTransaksi::orderByDesc('created_at')->get(), 0);
    //     dd($data);
    //     return Excel::download(new DepoWdExport($data), 'Historycoin.xlsx');
    // }
}
