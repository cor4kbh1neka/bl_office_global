<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Bonus;
use App\Models\BonusPengecualian;
use App\Models\Listbonus;
use App\Models\Listbonusdetail;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\WinlossbetDay;
use App\Models\DepoWd;
use App\Models\HistoryTransaksi;
use App\Models\winlossDay;
use App\Models\winlossMonth;
use App\Models\winlossYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CashbackRollinganExport;

class BonusdsController extends Controller
{
    public function indexlist(Request $request)
    {
        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari');
        $gabunghingga = $request->input('gabunghingga');
        $search_invoice = $request->input('searchinvoice');

        $query = Listbonus::orderByDesc('created_at');

        if (!empty($bonus)) {
            $query->where('jenis_bonus', $bonus);
        }

        if (!empty($gabungdari) && !empty($gabunghingga)) {
            $query->where('periodedari', '>=', $gabungdari)
                ->where('periodesampai', '<=', $gabunghingga);
        }

        if (!empty($search_invoice)) {
            $query->where('no_invoice', 'like', '%' . $search_invoice . '%');
        }

        $data = $query->paginate(10);
        return view('bonusds.indexlist', [
            'title' => 'List Cashback dan Rollingan',
            'data' => $data,
            'bonus' => $bonus,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'search' => $search_invoice
        ]);
    }

    public function indexdetail($listbonus_id)
    {
        $data = Listbonus::where('id', $listbonus_id)->first();
        $datadetail = Listbonusdetail::where('listbonus_id', $listbonus_id)->get();
        $dataBonusPengecualian = BonusPengecualian::get();

        return view('bonusds.indexdetail', [
            'title' => 'Cashback dan Rollingan',
            'data' => $data,
            'datadetail' => $datadetail,
            'dataBonusPengecualian' => $dataBonusPengecualian,
            'isproses' => true,
            'listbonus_id' => $listbonus_id,
            'total_user' => $datadetail->count(),
            'total_bonus' => $datadetail->sum('bonus')
        ]);
    }

    public function index(Request $request)
    {
        $dataBonusPengecualian = BonusPengecualian::get();
        $data = MemberAktif::get();

        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari') != null ? date('Y-m-d', strtotime($request->input('gabungdari'))) : '';
        $gabunghingga =  $request->input('gabunghingga') != null ? date('Y-m-d', strtotime($request->input('gabunghingga'))) : '';
        $pengecualian = $request->input('kecuali');

        $results = $this->getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian);

        if ($results instanceof Collection && !$results->isEmpty()) {
            $isproses = true;
        } else {
            $isproses = false;
        }

        // if ($bonus != null && $gabungdari !== null && $gabunghingga !== null && $pengecualian !== null) {
        //     $userStats = [];

        //     foreach ($data as $index => $d) {
        //         // if ($d->username == 'l21wantos') {
        //         foreach ($dataPortfolio as $portfolio) {
        //             $apiResult = $this->getApi($d->username, $portfolio, $gabungdari, $gabunghingga);

        //             if (isset($apiResult['result']) && is_array($apiResult['result']) && !empty($apiResult['result'])) {
        //                 foreach ($apiResult['result'] as $result) {
        //                     if ($result['status'] == 'lose' || $result['status'] == 'won') {
        //                         if (!isset($userStats[$index])) {
        //                             $userStats[$index] = [
        //                                 'username' => $d->username,
        //                                 'totalStake' => 0,
        //                                 'totalWinLose' => 0
        //                             ];
        //                         }
        //                         $userStats[$index]['totalStake'] += $result['stake'];
        //                         $userStats[$index]['totalWinLose'] += $result['winLost'];
        //                     }
        //                 }
        //             }
        //         }
        //         // }
        //     }
        //     dd($userStats);
        // }


        $this->$data = [];
        return view('bonusds.index', [
            'title' => 'Cashback dan Rollingan',
            'data' => $results,
            'dataBonusPengecualian' => $dataBonusPengecualian,
            'totalnote' => 0,
            'bonus' => $bonus,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'pengecualian' => $pengecualian,
            'isproses' => $isproses,
            'totaluser' => $results->count(),
            'nominalbonus' => $results->sum('totalbonus') * 1000
        ]);
    }

    private function getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian)
    {
        if ($bonus == 'cashback') {
            /*bonus cahsback*/
            $dataPortfolio = ['Casino', 'Games', 'SeamlessGame', 'ThirdPartySportsBook'];
        } else {
            /*bonus rolingan*/
            $dataPortfolio = ['SportsBook', 'VirtualSports'];
        }

        if ($bonus != null && $gabungdari !== null && $gabunghingga !== null && $pengecualian !== null) {
            $hunter = Member::where('status', 4)
                ->where('keterangan', $pengecualian)
                ->pluck('username')
                ->values()
                ->toArray();

            $query = WinlossbetDay::whereIn('portfolio', $dataPortfolio)
                ->whereBetween('created_at', [$gabungdari . ' 00:00:00', $gabunghingga . ' 23:59:59'])
                ->select('username', DB::raw('SUM(stake) as totalstake'), DB::raw('SUM(winloss) as totalwinloss'))
                ->groupBy('username');

            // dd(WinlossbetDay::get());
            if (!empty($hunter)) {
                $query->whereNotIn('username', $hunter);
            }

            $results = $query->get();

            foreach ($results as $key => $result) {
                $mBonus = Bonus::where('jenis_bonus', $bonus)->first();
                $total = $bonus == 'cashback' ? $result->totalwinloss : $result->totalstake;
                if ($bonus == 'cashback') {
                    if ($total <= ($mBonus->min * -1)) {
                        $result->totalbonus = (abs($total) * $mBonus->persentase) / 100;
                    } else {
                        unset($results[$key]);
                    }
                } else {
                    if ($total >= $mBonus->min) {
                        $result->totalbonus = ($total * $mBonus->persentase) / 100;
                    } else {
                        unset($results[$key]);
                    }
                }
            }
        } else {
            $results = collect();
        }

        return $results;
    }

    private function getApi($username, $portfolio, $gabungdari, $gabunghingga)
    {
        $data = [
            "username" => $username,
            "portfolio" => $portfolio,
            "startDate" => $gabungdari . "T00:00:00.540Z",
            "endDate" => $gabunghingga . "T23:59:59.540Z",
            "companyKey" => env('COMPANY_KEY'),
            "language" => "en",
            "serverId" => env('SERVERID')
        ];
        $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-bet-list-by-modify-date.aspx';
        $response = Http::post($apiUrl, $data);

        return $response->json();
    }

    public function store(Request $request, $bonus, $gabungdari, $gabunghingga, $kecuali)
    {

        $data = $request->request->all();

        $bonuses = array_column($data, 'bonus');
        $totalBonus = array_sum($bonuses);

        $createListbonus = Listbonus::create([
            'no_invoice' => $this->generateInvoiceNumber(),
            'periodedari' => $gabungdari,
            'periodesampai' => $gabunghingga,
            'jenis_bonus' => $bonus,
            'kecuali' => $kecuali,
            'total' => $totalBonus,
            'status' => 'Processed',
            'processed_by' => Auth::user()->username
        ]);
        if ($createListbonus) {

            foreach ($data as $d) {
                $createDetail = Listbonusdetail::create([
                    'listbonus_id' => $createListbonus['id'],
                    'username' => $d['username'],
                    'turnover' => $d['stake'],
                    'winlose' => $d['winloss'],
                    'bonus' => $d['bonus']
                ]);

                if ($createDetail) {
                    // 1. requestApiSeamless
                    $txnid = $this->generateTxnid('D');
                    $prosesApiDepo = $this->apiDepo($d['username'], $d['bonus'], $txnid);

                    if ($prosesApiDepo["error"]["id"] === 0) {
                        // 2.create DepoWd DPM
                        $balance = Balance::where('username', $d['username'])->first();
                        if ($balance) {
                            $balance = $balance->amount;
                        }
                        $keterangan = 'Bonus ' . $bonus;
                        $this->createDepoWD($d['username'], $d['bonus'], $keterangan, 'DPM', $txnid, $balance, Auth::user()->username, 1);

                        // 3. Process balance
                        $prosesBalance = $this->processBalance($d['username'], 'DP', $d['bonus']);

                        //4. Process win Lose
                        $this->addDataWinLoss($d['username'], $d['bonus'], "deposit");

                        // 5.Create History
                        $this->addDataHistory($d['username'], $txnid, '', strtolower($bonus), 'bonus', 0, $d['bonus'], $prosesBalance["balance"]);
                    }

                    $maxAttempts4404 = 10;
                    $attempt4404 = 0;
                    while ($prosesApiDepo["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
                        $txnid = $this->generateTxnid('D');
                        $data["txnId"] = $txnid;
                        $resultsApi = $this->apiDepo($d['username'], $d['bonus'], $txnid);
                        if ($resultsApi["error"]["id"] === 0) {
                            // 2.create DepoWd DPM
                            $balance = Balance::where('username', $d['username'])->first()->amount;
                            $keterangan = 'Bonus ' . $bonus;
                            $this->createDepoWD($d['username'], $d['bonus'], $keterangan, 'DPM', $txnid, $balance, Auth::user()->username, 'Approved');

                            // 3. Process balance
                            $prosesBalance = $this->processBalance($d['username'], 'DP', $d['bonus']);

                            //4. Process win Lose
                            $this->addDataWinLoss($d['username'], $d['bonus'], "deposit");

                            // 5.Create History
                            $this->addDataHistory($d['username'], $txnid, '', strtolower($bonus), 'bonus', 0, $d['bonus'], $prosesBalance["balance"]);
                        }
                        $attempt4404++;
                    }
                }
            }
        }

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    private function createDepoWD($username, $amount, $keterangan, $jenis, $txnid, $balance, $approved_by, $status)
    {
        $result = DepoWd::create([
            'username' => $username,
            'amount' => $amount,
            'keterangan' => $keterangan,
            'jenis' => $jenis,
            'txnid' => $txnid,
            'balance' => $balance,
            'approved_by' => $approved_by,
            'status' => $status,
        ]);
        return $result;
    }

    private function generateInvoiceNumber($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $invoiceNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $invoiceNumber .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $invoiceNumber;
    }

    private function apiDepo($username, $amount, $txnid)
    {
        $data = [
            "Username" => $username,
            "TxnId" => $txnid,
            "Amount" => $amount,
            'companyKey' => env('COMPANY_KEY'),
            'serverId' => env('SERVERID')
        ];

        $apiUrl = env('BODOMAIN') . '/web-root/restricted/player/deposit.aspx';

        $response = Http::post($apiUrl, $data);
        return $response->json();
    }

    function generateTxnid($jenis)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        if ($jenis == 'D') {
            $length = 17;
        } else {
            $length = 10;
        }

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }

    public function processBalance($username, $jenis, $amount)
    {
        try {
            DB::beginTransaction();

            $balance = Balance::where('username', $username)->lockForUpdate()->first();

            if (!$balance) {
                throw new \Exception('Saldo pengguna tidak ditemukan.');
            }

            if ($jenis == 'DP') {
                $balance->amount += $amount;
            } else {
                $balance->amount -= $amount;
            }

            $balance->save();

            DB::commit();
            return [
                "status" => 'success',
                "balance" => $balance->amount
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                "status" => 'fail',
                "balance" => 0
            ];
        }
    }

    public function addDataWinLoss($username, $amount, $jenis)
    {
        /* W/L harian */
        $winLoss = winlossDay::where('username', $username)->where('day', date("d"))->where('month', date("m"))->where('year', date("Y"))->first();
        if (!$winLoss) {
            WinlossDay::create([
                'username' => $username,
                'count' => 1,
                'day' => date("d"),
                'month' => date("m"),
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLoss->increment('count');
            if ($jenis == 'deposit') {
                $winLoss->increment('deposit', $amount);
            } else {
                $winLoss->increment('withdraw', $amount);
            }
        }

        /* W/L bulanan */
        $winLossMonth = winlossMonth::where('username', $username)->where('month', date("m"))->where('year', date("Y"))->first();
        if (!$winLossMonth) {
            winlossMonth::create([
                'username' => $username,
                'count' => 1,
                'month' => date("m"),
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLossMonth->increment('count');
            if ($jenis == 'deposit') {
                $winLossMonth->increment('deposit', $amount);
            } else {
                $winLossMonth->increment('withdraw', $amount);
            }
        }

        /* W/L tahunan */
        $winLossYear = winlossYear::where('username', $username)->where('year', date("Y"))->first();
        if (!$winLossYear) {
            winlossYear::create([
                'username' => $username,
                'count' => 1,
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLossYear->increment('count');
            if ($jenis == 'deposit') {
                $winLossYear->increment('deposit', $amount);
            } else {
                $winLossYear->increment('withdraw', $amount);
            }
        }

        return;
    }

    public function addDataHistory($username, $txnid, $refno, $keterangan, $status, $debit, $kredit, $balance)
    {
        $result = HistoryTransaksi::create([
            'username' => $username,
            'invoice' => $txnid,
            'refno' => $refno,
            'keterangan' => $keterangan,
            'status' => $status,
            'debit' => $debit,
            'kredit' => $kredit,
            'balance' => $balance
        ]);

        return $result;
    }

    public function cancel(Request $request)
    {
        // $listbonus_id = $request->listbonus_id;
        // $updateListbonus = Listbonus::where('id', $listbonus_id)->update([
        //     'status' => 'Cancel'
        // ]);

        // if ($updateListbonus) {
        //     $dataListbonus = Listbonusdetail::where('listbonus_id', $listbonus_id)->get();

        //     foreach ($dataListbonus as $i => $d) {

        //         // 3. Process balance
        //         $prosesBalance = $this->processBalance($d->username, 'WD', $d->bonus);
        //         if ($prosesBalance) {
        //         }

        //         // 1. requestApiSeamless
        //         $txnid = $this->generateTxnid('D');
        //         $prosesApiDepo = $this->apiDepo($d['username'], $d['bonus'], $txnid);

        //         if ($prosesApiDepo["error"]["id"] === 0) {
        //             // 2.create DepoWd DPM
        //             $balance = Balance::where('username', $d['username'])->first();
        //             if ($balance) {
        //                 $balance = $balance->amount;
        //             }
        //             $keterangan = 'Bonus ' . $bonus;
        //             $this->createDepoWD($d['username'], $d['bonus'], $keterangan, 'DPM', $txnid, $balance, Auth::user()->username, 1);



        //             //4. Process win Lose
        //             $this->addDataWinLoss($d['username'], $d['bonus'], "deposit");

        //             // 5.Create History
        //             $test33 = $this->addDataHistory($d['username'], $txnid, '', strtolower($bonus), 'bonus', 0, $d['bonus'], $prosesBalance["balance"]);
        //         }
        //     }
        // }

        return;
    }

    public function export(Request $request)
    {;
        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari') != null ? date('Y-m-d', strtotime($request->input('gabungdari'))) : '';
        $gabunghingga =  $request->input('gabunghingga') != null ? date('Y-m-d', strtotime($request->input('gabunghingga'))) : '';
        $pengecualian = $request->input('kecuali');

        $data = $this->getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian);
        foreach ($data as &$d) {
            $d->totalstake *= 1000;
            $d->totalwinloss *= 1000;
            $d->totalbonus *= 1000;
        }
        return Excel::download(new CashbackRollinganExport($data), 'MemberOutstanding-' . $bonus . '-' . $gabungdari . '-' . $gabunghingga . '.xlsx');
    }
}
