<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class HistorygamedsController extends Controller
{
    public function index(Request $request)
    {

        $username = $request->query('username');
        $portfolio = $request->query('portfolio');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $refNo = $request->query('refNo');
        $sportsType = $request->query('sportsType');
        $status = $request->query('status');

        if ($refNo != '') {
            $username = '';
            $startDate = '';
            $endDate = '';
        }

        $Message = '';
        $data = [];

        if ($refNo != '' && $portfolio != '') {
            $data = $this->requestApi('get-bet-list-by-refnos', [
                'refNos' => $refNo,
                'portfolio' => $portfolio,
                'companyKey' => env('COMPANY_KEY'),
                'language' => 'en',
                'serverId' => env('SERVERID')
            ]);
            if (!$data) {
                $data = [];
            } else {
                $data = $data["result"];
                // dd($data);
            }
        }

        if ($username != '' && $refNo == '') {
            $data = $this->requestApi('get-bet-list-by-modify-date', [
                'username' => $username,
                'portfolio' => $portfolio,
                'startDate' => $startDate . 'T00:00:00.540Z',
                'endDate' => $endDate . 'T23:59:59.540Z',
                'companyKey' => env('COMPANY_KEY'),
                'language' => 'en',
                'serverId' => env('SERVERID')
            ]);

            if ($data["error"]["id"] != 0) {
                $Message = "Username tidak terdaftar";
                $data = [];
            } else {
                $data = $data["result"];
            }
        }

        if ($portfolio == 'SportsBook') {
            $data_filter_sportsTypes = array_unique(array_column($data, 'sportsType'));
        } else if ($portfolio == 'VirtualSports' || $portfolio == 'Games') {
            $data_filter_sportsTypes = array_unique(array_column($data, 'productType'));
        } else {
            $data_filter_sportsTypes = [];
        }

        // dd($data);
        if ($sportsType != '') {
            $data = array_filter($data, function ($item) use ($portfolio, $sportsType) {
                if ($portfolio == 'SportsBook') {
                    return $item['sportsType'] === $sportsType;
                } else if ($portfolio == 'VirtualSports' || $portfolio == 'Games') {
                    return $item['productType'] === $sportsType;
                }
            });
        }

        if ($status != '') {
            $data = array_filter($data, function ($item) use ($status) {
                return $item['status'] === $status;
            });
        }
        $data = $this->filterAndPaginate(collect($data), 20);

        //DATA SPORT TYPE   
        // $dataSportType = [
        //     'Football', 'Basketball', 'American Football', 'Ice Hockey', 'Badminton', 'Pool/Snooker', 'Motor Sport', 'Tennis', 'Baseball', 'Volleyball', 'Others', 'Golf', 'Boxing', 'Cricket', 'Table Tennis', 'Rugby', 'Handball', 'Cycling', 'Athletics', 'Beach Soccer', 'Futsal', 'Special'
        // ];
        return view('historygameds.index', [
            'title' => 'History Game',
            'data' => $data,
            'totalnote' => 0,
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'refNo' => $refNo,
            'sportsType' => $sportsType,
            'status' => $status,
            // 'dataSportType' => $dataSportType,
            'Message' => $Message,
            'data_filter_sportsTypes' => $data_filter_sportsTypes
        ]);
    }

    public function detail($refNo, $portfolio)
    {
        $data = $this->requestApi('get-bet-list-by-refnos', [
            'refNos' => $refNo,
            'portfolio' => $portfolio,
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')
        ]);

        if (!empty($data['result'])) {
            $data = $data['result'][0];
        } else {
            $data = $data['result'];
        }

        return view('historygameds.detail', [
            'title' => 'detail invoice',
            'totalnote' => 0,
            'data' => $data,
            'portfolio' => $portfolio
        ]);
    }

    private function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            // $statusCode = $response->status();
            // $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }
    public function filterAndPaginate($data, $page) // ini versi yang lengkap
    {
        $query = collect($data);
        $parameter = [
            'username'
        ]; 

        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $query = $query->filter(function ($item) use ($isiSearch) {
                    return stripos($item[$isiSearch], request($isiSearch)) !== false;
                });
            }
        }

        $parameter = array_merge($parameter, [
            'portfolio',
            'startDate',
            'endDate',
            'refNo',
            'sportsType',
            'status',
        ]);

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
}
