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
use App\Exports\HistoryTransaksiExport;
use Illuminate\Support\Collection;


class HistorytransaksidsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        if ($request->getQueryString() && request('username')) {
            $data = $this->filterAndPaginate(HistoryTransaksi::where('username', $request->query('username'))->orderByDesc('created_at')->orderByDesc('urutan')->get(), 20);
        }

        $currentDate = now();
        $transdari = $request->input('transdari', $currentDate->copy()->subDays(30)->format('Y-m-d') . ' 00:00');
        $transhingga = $request->input('transhingga', $currentDate->format('Y-m-d') . ' 23:59');

        return view('historytransaksids.index', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'transdari' => $transdari,
            'transhingga' => $transhingga,
            'is_old' => false
        ]);
    }

    public function index_old(Request $request)
    {
        $paginatedData = [];

        if ($request->getQueryString() && request('username')) {
            $paginatedData = $this->filterAndPaginateOld(20, $request);
        }

        $currentDate = now();
        $transdari = $request->input('transdari', $currentDate->copy()->subMonth()->startOfMonth()->format('Y-m-d') . 'T00:00');
        $transhingga = $request->input('transhingga', $currentDate->copy()->subMonth()->endOfMonth()->format('Y-m-d') . 'T23:59');

        return view('historytransaksids.index', [
            'title' => 'List History',
            'data' => $paginatedData,
            'transdari' => $transdari,
            'transhingga' => $transhingga,
            'is_old' => true
        ]);
    }

    private function getOldData($username, $invoice, $status, $transdari, $transhingga)
    {
        try {
            $parameters = [
                'transdari' => $transdari,
                'transhingga' => $transhingga
            ];

            if (!empty($username)) {
                $parameters['username'] = $username;
            }

            if (!empty($invoice)) {
                $parameters['invoice'] = $invoice;
            }
            
            if (!empty($status)) {
                $parameters['status'] = $status;
            }
            
            $response = Http::withHeaders([
                'utilitiesgenerate' => env('UTILITIES_GENERATE_OLD'),
                'Accept' => 'application/json'
            ])->get(env('OLDDOMAIN') . 'api/olddata/historytransaksi', $parameters);

            $data = $response->successful() ? json_decode($response->body(), true) : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return $data;
    }

    public function filterAndPaginateOld($page, $request)
    {
        $username = $request->username;
        $invoice = $request->invoice ?? '';
        $checkinvoice = $request->checkinvoice ?? '';
        $status = isset($request->status) ? $request->status : '';
        $checkstatus = $request->checkstatus ?? '';
        $transdari = $request->has('transdari') ? $request->transdari : Carbon::now()->subDays(30)->toDateString();
        $checktransdari = $request->checktransdari ?? '';
        $transhingga = $request->has('transhingga') ? $request->transhingga : Carbon::now()->toDateString();
        $checktranshingga = $request->checktranshingga ?? '';

        if ($username) {
            $username = $username;
        }

        if (!($checkinvoice == 'on' && $invoice != '')) {
            $invoice = '';
        } 

        if (!($checkstatus == 'on' && $status != '')) {
            $status = '';
        }

        if (!($checktransdari == 'on' && $transdari != '')) {
            $transdari = '';
        } else {
            $transdari = Carbon::parse($transdari)->format('Y-m-d H:i') . ':00';
        }

        if (!($checktranshingga == 'on' && $transhingga != '')) {
            $transhingga = '';
        } else {
            $transhingga = Carbon::parse($transhingga)->format('Y-m-d H:i') . ':59';
        }

        $data = $this->getOldData($username, $invoice, $status, $transdari, $transhingga);

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
        $parameters = [
            'status'
        ];

        foreach ($parameters as $searchParam) {
            if (request($searchParam)) {
                if (request($searchParam) != 'null') {
                    $query = $query->filter(function ($item) use ($searchParam) {
                        return stripos($item[$searchParam], request($searchParam)) !== false;
                    });
                }
            }
        }

        // Filter untuk Tanggal, comment aja klau tidak terpakai :D
        if (request('transdari') && request('transhingga')) {
            $transdariInput = request('transdari');
            $transhinggaInput = request('transhingga');

            $transdari = Carbon::createFromFormat('Y-m-d\TH:i', $transdariInput)->format('Y-m-d H:i:s');
            $transhingga = Carbon::createFromFormat('Y-m-d\TH:i', $transhinggaInput)->format('Y-m-d H:i:s');
            $transhingga = substr($transhingga, 0, -2) . '59';

            $query = $query->whereBetween('created_at', [$transdari, $transhingga]);
        }

        // Filter untuk strict data
        // if (request('username')) {
        //     $inputUsername = request('username');
        //     $query = $query->filter(function ($item) use ($inputUsername) {
        //         return $item['username'] === $inputUsername;
        //     });
        // }
        if (request('invoice')) {
            $inputRefno = request('invoice');
            $query = $query->filter(function ($item) use ($inputRefno) {
                return stripos($item['invoice'], $inputRefno) !== false;
            });
        }
        // dd(request('checkall'));
        // dd(!request('checkall') || !request(['checkinvoice', 'checkstatus', 'checktransdari', 'checktranshingga']));
        if (!request('checkall') || !request(['checkinvoice', 'checkstatus', 'checktransdari', 'checktranshingga'])) {
            return $query = [];
        }

        $parameters = array_merge($parameters, [
            'username',
            'invoice',
            'transdari',
            'transhingga',
            'checkinvoice',
            'checkstatus',
            'checktransdari',
            'checktranshingga',
            'checkall',
        ]);

        if ($page == 0) {
            return $query->values();
        } else {
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

            // Append parameters to the pagination links
            foreach ($parameters as $searchParam) {
                if (request($searchParam)) {
                    $paginatedItems->appends($searchParam, request($searchParam));
                }
            }
            return  $paginatedItems;
        }
    }

    public function export(Request $request)
    {
        $is_old = $request->is_old;
        if ($is_old) {
            $data = $this->filterAndPaginateOld(999999999999999, $request);
            $data = $data->getCollection();
        } else {
            $data = $this->filterAndPaginate(HistoryTransaksi::orderByDesc('created_at')->orderByDesc('urutan')->get(), 0);
        }

        // $data = collect($data);
        return Excel::download(new HistoryTransaksiExport($data), 'Historycoin.xlsx');
    }
}
