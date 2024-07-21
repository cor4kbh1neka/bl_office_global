<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\DepoWd;
use App\Models\Member;
use App\Models\Transactions;
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
        $fromdate = $request->query('fromdate') ?? date('Y-m-d', strtotime('-1 day'));
        $todate = $request->query('todate') ?? date('Y-m-d', strtotime('-1 day'));

        $cash_balance = 0;
        $member_balance = Balance::sum('amount');
        $total_balance = $member_balance;

        $count_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->whereIn('jenis', ['DP', 'DPM'])->count();
        $count_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->whereIn('jenis', ['WD', 'WDM'])->count();

        $sum_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->whereIn('jenis', ['DP', 'DPM'])->sum('amount');
        $sum_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->whereIn('jenis', ['WD', 'WDM'])->sum('amount');

        $sum_depo_real = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->where('jenis', 'DP')->sum('amount');
        $sum_depo_manual = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->where('jenis', 'DPM')->sum('amount');
        $sum_wd_real = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->where('jenis', 'WD')->sum('amount');
        $sum_wd_manual = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->where('status', 1)->where('jenis', 'WDM')->sum('amount');

        $count_all_status_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->whereIn('jenis', ['DP', 'DPM'])->count();
        $count_all_status_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->whereIn('jenis', ['WD', 'WDM'])->count();

        $count_settled = $this->getDataSettled($fromdate, $todate)->count_settled;
        $total_settled = $this->getDataSettled($fromdate, $todate)->total_settled;

        $totalmember = Member::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->count();
        $total_new_member_regis = $totalmember;
        $total_new_member_deposit = $this->getDataNewmember($fromdate, $todate);

        $total_member_online = $this->getDataMemberOnline($fromdate, $todate);

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
            'count_depo' => $count_depo,
            'count_wd' => $count_wd,
            'sum_depo' => $sum_depo,
            'sum_wd' => $sum_wd,
            'sum_depo_real' => $sum_depo_real,
            'sum_depo_manual' => $sum_depo_manual,
            'sum_wd_real' => $sum_wd_real,
            'sum_wd_manual' => $sum_wd_manual,
            'count_all_status_depo' => $count_all_status_depo,
            'count_all_status_wd' => $count_all_status_wd,
            'count_settled' => $count_settled,
            'total_settled' => $total_settled,
            'totalmember' => $totalmember,
            'total_new_member_regis' => $total_new_member_regis,
            'total_new_member_deposit' => $total_new_member_deposit,
            'total_member_online' => $total_member_online
        ]);
    }

    private function getDataSettled($fromdate, $todate)
    {
        $sql = "SELECT SUM(A.amount) as total_settled, count(A.id) AS count_settled FROM transaction_saldo A
            INNER JOIN (
            SELECT ts.id, ts.trans_id, ts.urutan, ts.created_at, t.transfercode
            FROM transaction_status ts
            INNER JOIN transactions t ON ts.trans_id = t.id
            INNER JOIN (
               SELECT t2.transfercode, 
                       MAX(ts2.created_at) AS max_created_at, 
                       MAX(ts2.urutan) AS max_urutan
                FROM transaction_status ts2
                INNER JOIN transactions t2 ON ts2.trans_id = t2.id
                GROUP BY t2.transfercode
            ) sub ON t.transfercode = sub.transfercode AND ts.created_at = sub.max_created_at AND ts.urutan = sub.max_urutan
            where ts.status NOT IN ('Settled') AND t.created_at >= ? AND t.created_at <= ?
            ORDER BY ts.created_at DESC, ts.urutan DESC
            ) B ON A.transtatus_id = B.id;";

        $results = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);
        return $results[0];
    }

    private function getDataNewmember($fromdate, $todate)
    {
        $sql = "SELECT * FROM (
        SELECT username, MIN(created_at) as created_at FROM depo_wd
        where status = '1' and jenis IN ('DP', 'DPM')
        group by username) A
        WHERE A.created_at >= ? AND A.created_at <= ?";

        $results = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);

        return count($results);
    }

    private function getDataMemberOnline($fromdate, $todate)
    {
        $sql = "SELECT count(username) as totalmo FROM (
            SELECT username FROM transactions
            WHERE created_at >= ? AND created_At <= ?
            group by username, DATE(created_at)) A";
        $result = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);

        return $result[0]->totalmo;
    }
}
