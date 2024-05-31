<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use App\Models\Xdpwd;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DepositdsController extends Controller
{
    public function index()
    {
        if (Route::is('depositds')) {
            $jenis = 'DP';
        } elseif (Route::is('withdrawds')) {
            $jenis = 'WD';
        }

        $dataCountDepoWd = DepoWd::select('bank', DB::raw('count(id) as count'))
            ->where('status', 0)
            ->where('jenis', $jenis)
            ->groupBy('bank')
            ->get();

        /* Data master bank */
        $dataBank = $this->getApiMasterBank();
        sort($dataBank);
        $dataBank = array_unique($dataBank);
        $allDataBank = [];
        foreach ($dataBank as $index => $item1) {
            $allDataBank[$index]['bnkmstrxyxyx'] = $item1;
            $allDataBank[$index]['count'] = 0;

            foreach ($dataCountDepoWd as $item2) {
                if ($item1 === $item2->bank) {
                    $allDataBank[$index]['count'] = $item2->count;
                    break;
                }
            }
        }

        $dataBank = $allDataBank;

        /* History transkasi */
        $dataTransaksi = DepoWd::whereIn('status', [1, 2])->where('jenis', $jenis)->orderBy('updated_at', 'DESC')->get();

        /* Data depo wd */
        $dataDepoWd = DepoWd::with('member:username,status')->where('status', 0)->where('jenis', $jenis)->orderBy('created_at', 'ASC')->get();

        /* View depo / wd */
        if ($jenis == 'WD') {
            $path = 'withdrawds.index';
            $title = 'Withdrawal';
        } else {
            $path = 'depositds.index';
            $title = 'Deposit';
        }

        return view($path, [
            'title' => $title,
            'totalnote' => 0,
            'data' => $dataDepoWd,
            'dataTransaksi' => $dataTransaksi,
            'dataBank' => $dataBank
        ]);
    }

    private function getApiMasterBank()
    {
        // "status" => "success"
        $ApiBank = $this->getApi(env('DOMAIN') . '/banks/v2/groupbank3');
        unset($ApiBank['headers']);
        $ApiBankExcept = $this->getApi(env('DOMAIN') . '/banks/exc/groupbank3');
        unset($ApiBankExcept['headers']);

        $data1 = [];
        foreach ($ApiBank as $dts) {
            foreach ($dts as $dt) {
                foreach ($dt["data_bank"] as $d) {
                    $data1[] = $d['namebankxxyy'];
                }
            }
        }

        $data2 = [];
        foreach ($ApiBankExcept as $dts) {
            foreach ($dts as $dt) {
                foreach ($dt["data_bank"] as $d) {
                    $data2[] = $d['namebankxxyy'];
                }
            }
        }

        $allDataBank = array_merge($data1, $data2);
        $allDataBank = [];
        return $allDataBank;
    }

    private function getApi($url)
    {
        // Define the headers you want to add
        $headers = [
            'Accept' => 'application/json',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ];

        $response = Http::withHeaders($headers)->get($url);

        $response = $response->json();

        if ($response['status'] == 'success') {

            $response = $response['data'];
        } else {
            $response = [];
        }

        return $response;
    }

    public function getDataHistory($username, $jenis)
    {
        if ($jenis == "ALL") {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        } else {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->where('jenis', $jenis)->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        }


        return $dataHistory;
    }
}
