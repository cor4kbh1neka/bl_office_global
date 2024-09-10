<?php

namespace App\Http\Controllers;

use App\Models\Balance;
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
use App\Models\ListError;
use App\Models\Product;

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
        $datadetail = Listbonusdetail::select('listbonus_detail.*', 'products.productsname')
            ->join('products', 'listbonus_detail.portfolio', '=', 'products.portfolio')
            ->where('listbonus_detail.listbonus_id', $listbonus_id)
            ->get();
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
        $detail_bonus = $request->input('detail_bonus');

        $detail_bonus_array = explode(', ', $detail_bonus);

        $results = $this->getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian, $detail_bonus_array);

        if ($results instanceof Collection && !$results->isEmpty()) {
            $isproses = true;
        } else {
            $isproses = false;
        }

        $this->$data = [];
        $detail_bonus_data = Product::where('jenis_bonus', $bonus)->get()->map(function ($item) use ($detail_bonus_array) {
            return [
                'productsname' => $item->productsname,
                'ischeck' => in_array($item->productsname, $detail_bonus_array)
            ];
        })->toArray();

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
            'nominalbonus' => $results->sum('totalbonus') * 1000,
            'detail_bonus' => $detail_bonus,
            'detail_bonus_array' => $detail_bonus_data
        ]);
    }

    private function getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian, $detail_bonus)
    {
        $data_product = Product::whereIn('productsname', $detail_bonus)
            ->select('portfolio', 'persen_bonus', 'min_lose_bet')
            ->get()
            ->toArray();
        $dataPortfolio = array_column($data_product, 'portfolio');


        if ($bonus != null && $gabungdari !== null && $gabunghingga !== null && $pengecualian !== null) {
            $hunter = Member::where('status', 4)
                ->where('keterangan', $pengecualian)
                ->pluck('username')
                ->values()
                ->toArray();

            $query = WinlossbetDay::leftJoin('products', 'winlossbet_day.portfolio', '=', 'products.portfolio')
                ->whereIn('winlossbet_day.portfolio', $dataPortfolio)
                ->whereBetween('winlossbet_day.created_at', [$gabungdari . ' 00:00:00', $gabunghingga . ' 23:59:59'])
                ->select(
                    'winlossbet_day.username',
                    'winlossbet_day.portfolio',
                    'products.productsname',
                    DB::raw('SUM(winlossbet_day.stake) as totalstake'),
                    DB::raw('SUM(winlossbet_day.winloss) as totalwinloss')
                )
                ->groupBy('winlossbet_day.username', 'winlossbet_day.portfolio', 'products.productsname')
                ->orderBy('totalwinloss', 'ASC')
                ->orderBy('totalstake', 'DESC');

            if (!empty($hunter)) {
                $query->whereNotIn('winlossbet_day.username', $hunter);
            }

            $results = $query->get();
            foreach ($results as $key => $result) {

                $mBonus = array_filter($data_product, function ($item) use ($result) {
                    return $item['portfolio'] === $result->portfolio;
                });

                foreach ($mBonus as $item) {
                    $mBonus = $item;
                }

                $total = $bonus == 'cashback' ? $result->totalwinloss : $result->totalstake;
                if ($bonus == 'cashback') {
                    if ($total <= ($mBonus['min_lose_bet'] * -1)) {
                        $result->totalbonus = (abs($total) * $mBonus['persen_bonus']) / 100;
                    } else {
                        unset($results[$key]);
                    }
                } else {
                    if ($total >= $mBonus['min_lose_bet']) {
                        $result->totalbonus = ($total * $mBonus['persen_bonus']) / 100;
                    } else {
                        unset($results[$key]);
                    }
                }

                // Tambahkan filter totalbonus >= 0.01
                if ($result->totalbonus < 0.01) {
                    $result->totalbonus = round($result->totalbonus, 2);
                    unset($results[$key]);
                }
            }
        } else {
            $results = collect();
        }

        return $results;
    }

    public function store(Request $request, $bonus, $gabungdari, $gabunghingga, $kecuali, $bonusdetail)
    {
        $data = $request->request->all()["data"];
        $bonuses = array_column($data, 'bonus');

        $totalBonus = 0;

        $createListbonus = Listbonus::create([
            'no_invoice' => $this->generateInvoiceNumber(),
            'periodedari' => $gabungdari,
            'periodesampai' => $gabunghingga,
            'jenis_bonus' => $bonus,
            'kecuali' => $kecuali,
            'total' => $totalBonus,
            'status' => 'Processed',
            'processed_by' => Auth::user()->username,
            'bonus_detail' => $bonusdetail
        ]);
        if ($createListbonus) {
            foreach ($data as $index => $d) {
                if (!empty($d)) {
                    $nominalBonus = round($d['bonus'], 2);
                    $createDetail = Listbonusdetail::create([
                        'listbonus_id' => $createListbonus['id'],
                        'username' => $d['username'],
                        'turnover' => $d['stake'],
                        'winlose' => $d['winloss'],
                        'portfolio' => $d['portfolio'],
                        'bonus' => $nominalBonus
                    ]);

                    if ($createDetail) {
                        // 1. requestApiSeamless
                        $txnid = $this->generateTxnid('D');
                        $prosesApiDepo = $this->apiDepo($d['username'], $nominalBonus, $txnid);

                        if ($prosesApiDepo["error"]["id"] === 0) {
                            // 2.create DepoWd DPM
                            $balance = Balance::where('username', $d['username'])->first();
                            if ($balance) {
                                $balance = $balance->amount;
                            }
                            $keterangan = 'Bonus ' .  '(' . $d['productsname'] . ')';
                            $this->createDepoWD($d['username'], $nominalBonus, $keterangan, 'DPM', $txnid, $balance, Auth::user()->username, 1);

                            // 3. Process balance
                            $prosesBalance = $this->processBalance($d['username'], 'DP', $nominalBonus);

                            //4. Process win Lose
                            $this->addDataWinLoss($d['username'], $nominalBonus, "deposit");

                            // 5.Create History
                            $this->addDataHistory($d['username'], $txnid, '', 'bonus ' .  '(' . $d['productsname'] . ')', 'bonus', 0, $nominalBonus, $prosesBalance["balance"]);

                            $totalBonus += $nominalBonus;
                        } else {
                            $createDetail->delete();
                            $failedUsernames[] = $d['username'];
                            ListError::create([
                                'fungsi' => 'storebonusds',
                                'pesan_error' => $prosesApiDepo["error"]["id"],
                                'keterangan' => $d['username'] . ' / '  . $prosesApiDepo["error"]["msg"]
                            ]);
                        }
                    }
                }
            }

            $createListbonus->update([
                'total' => $totalBonus
            ]);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data'], 500);
        }

        if (!empty($failedUsernames)) {
            return response()->json(['message' => 'Data berhasil disimpan', 'id' => $createListbonus->id, 'failedUsernames' => $failedUsernames]);
        }
        return response()->json(['message' => 'Data berhasil disimpan', 'id' => $createListbonus->id, 'failedUsernames' => []]);
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
            "Username" => env('UNIX_CODE') . $username,
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

    public function export(Request $request)
    {
        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari') != null ? date('Y-m-d', strtotime($request->input('gabungdari'))) : '';
        $gabunghingga =  $request->input('gabunghingga') != null ? date('Y-m-d', strtotime($request->input('gabunghingga'))) : '';
        $pengecualian = $request->input('kecuali');
        $detail_bonus = $request->input('detail_bonus');
        $detail_bonus = explode(', ', $detail_bonus);

        $data = $this->getDataBonus($bonus, $gabungdari, $gabunghingga, $pengecualian, $detail_bonus);
        // foreach ($data as &$d) {
        //     $d->totalstake *= 1000;
        //     $d->totalwinloss *= 1000;
        //     $d->totalbonus *= 1000;
        // }

        return Excel::download(new CashbackRollinganExport($data), 'MemberOutstanding-' . $bonus . '-' . $gabungdari . '-' . $gabunghingga . '.xlsx');
    }

    public function getDataProduct($jenis_bonus)
    {
        return Product::where('jenis_bonus', $jenis_bonus)->get();
    }
}
