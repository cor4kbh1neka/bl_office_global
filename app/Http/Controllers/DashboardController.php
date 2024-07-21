<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\DepoWd;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            [
                'id' => '1',
                'nama' => 'Waantos',
                'alamat' => 'Pekanbaru',
                'notelp' => '0778007711',
                'tgllhir' => '12-09-1996',
                'tempatlahir' => 'sukajadi'
            ]
        ];

        $getdate = $request->query('getdate');
        $fromdate = $request->query('fromdate');
        $todate = $request->query('todate');

        $cash_balance = 0;
        $member_balance = Balance::sum('amount');
        $total_balance = $member_balance;

        $count_depo = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->whereIn('jenis', ['DP', 'DPM'])->count();

        $count_wd = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->whereIn('jenis', ['WD', 'WDM'])->count();

        $sum_depo = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->whereIn('jenis', ['DP', 'DPM'])->sum('amount');
        $sum_wd = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->whereIn('jenis', ['WD', 'WDM'])->sum('amount');

        $sum_depo_real = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->where('jenis', 'DP')->sum('amount');
        $sum_depo_manual = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->where('jenis', 'DPM')->sum('amount');
        $sum_wd_real = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->where('jenis', 'WD')->sum('amount');
        $sum_wd_manual = DepoWd::whereBetween('created_at', [$fromdate, $todate])->where('status', 1)->where('jenis', 'WDM')->sum('amount');

        $count_all_status_depo = DepoWd::whereBetween('created_at', [$fromdate, $todate])->whereIn('jenis', ['DP', 'DPM'])->count();
        $count_all_status_wd = DepoWd::whereBetween('created_at', [$fromdate, $todate])->whereIn('jenis', ['WD', 'WDM'])->count();

        $count_settled = $this->getDataSettled()->count_settled;
        $total_settled = $this->getDataSettled()->total_settled;

        $totalmember = Member::count();
        $totalmember = Member::count();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'data' => $data,
            'totalnote' => 0,
            'getdate' => $getdate,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'cash_balance' => $cash_balance,
            'member_balance' => $member_balance,
            'total_balance' => $total_balance,

        ]);
    }

    private function getDataSettled()
    {
        $sql = "SELECT SUM(A.amount) as total_settled, count(A.id) AS count_settled FROM transaction_saldo A
            INNER JOIN (
            SELECT ts.id, ts.trans_id, ts.urutan, ts.created_at, t.transfercode
            FROM transaction_status ts
            INNER JOIN transactions t ON ts.trans_id = t.id
            INNER JOIN (
                SELECT t2.transfercode, MAX(ts2.created_at) AS max_created_at, MAX(ts2.urutan) AS max_urutan
                FROM transaction_status ts2
                INNER JOIN transactions t2 ON ts2.trans_id = t2.id
                GROUP BY t2.transfercode
            ) sub ON t.transfercode = sub.transfercode AND ts.created_at = sub.max_created_at AND ts.urutan = sub.max_urutan
            where ts.status NOT IN ('Settled')
            ORDER BY ts.created_at DESC, ts.urutan DESC
            ) B ON A.transtatus_id = B.id;";

        $results = DB::select($sql);
        return $results[0];
    }
}
