<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
// use App\Models\Xreferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReportdsController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->query('username');
        $portfolio = $request->query('portfolio');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $data = $this->getDataWinLoss($request);
        $dataAmount = $this->getAmountUser($request);

        if ($data != null) {
            foreach ($data as &$element) {
                $username = $element['username'];

                $element['referral'] = 0;

                /* Amount */
                $matchingAmount = $dataAmount['username'] === $username ? $dataAmount['balance'] : 0;
                $element['amount'] = $matchingAmount;
            }
        } else if (!empty($dataAmount)) {
            $referral = 0;
            $data = [[
                'username' => $username,
                'amount' => $dataAmount['balance'],
                'referral' => $referral,
                'commission' => 0,
                'winlose' => 0
            ]];
        } else {
            $data = [];
        }

        return view('reportds.index', [
            'title' => 'Report',
            'data' => $data,
            'totalnote' => 0,
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    private function getDataWinLoss(Request $request)
    {
        $username = $request->query('username');
        $portfolio = $request->query('portfolio');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $data = [
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate . 'T00:00:00.540Z',
            'endDate' => $endDate . 'T23:59:59.540Z',
            "companyKey" => env('COMPANY_KEY'),
            "serverId" =>  env('SERVERID')
        ];
        $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-customer-report-by-win-lost-date.aspx';
        $response = Http::post($apiUrl, $data);
        $results = $response->json();

        if ($results["error"]["id"] == 0) {
            $result = $results["result"];
        } else {
            $result = [];
        }

        return $result;
    }

    private function getAmountUser(Request $request)
    {
        $username = $request->query('username');
        $data = [
            'Username' => $username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" =>  env('SERVERID')
        ];
        $apiUrl = env('BODOMAIN') . '/web-root/restricted/player/get-player-balance.aspx';
        $response = Http::post($apiUrl, $data);
        $results = $response->json();

        if ($results["error"]["id"] == 0) {
            $result = $results;
        } else {
            $result = [];
        }

        return $result;
    }

    public function winlosematch(Request $request)
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

        $dataAmount = $this->getAmountUser($request);

        $data = collect($data)->map(function ($item) use ($dataAmount) {
            $username = $item['username'];
            $item['saldo'] = empty($dataAmount["balance"]) ? 0 : $dataAmount["balance"];
            return $item;
        })->toArray();


        return view('reportds.winlosematch', [
            'title' => 'Report',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'refNo' => $refNo,
            'status' => $status,
            'sportsType' => $sportsType,
            'Message' => $Message,
            'data_filter_sportsTypes' => $data_filter_sportsTypes
        ]);
    }

    private function requestApi($endpoint, $data)
    {
        $url = env('BODOMAIN') . '/web-root/restricted/report/' . $endpoint . '.aspx';

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

    public function memberstatement()
    {

        return view('reportds.memberstatement', [
            'title' => 'Report',
            'totalnote' => 0,
        ]);
    }
}
