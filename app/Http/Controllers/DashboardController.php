<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\DepoWd;
use App\Models\Member;
use App\Models\RekapDashboardDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentHour = date('H');
        $is_maintenance = false;
        if ($currentHour >= 0 && $currentHour < 1) {
            $is_maintenance = true;
        } else {
            $getdate = $request->has('getdate') ? $request->getdate : 'yesterday';
            $fromdate = $request->has('fromdate') ? $request->fromdate : Carbon::yesterday()->format('Y-m-d');
            $todate = $request->has('todate') ? $request->todate : Carbon::yesterday()->format('Y-m-d');
            
            $data = $this->getDataDashboard($fromdate, $todate);

            $cash_balance = $data['sum_cash_balance'];
            $member_balance = $data['sum_member_balance'];
            $total_balance = $data['sum_total_balance'];

            $count_depo = $data['count_total_depo'];
            $count_wd = $data['count_total_wd'];

            $sum_depo = $data['sum_all_total_depo'];
            $sum_wd = $data['sum_all_total_wd'];

            $sum_depo_real = $data['sum_total_depo'];
            $sum_depo_manual = $data['sum_total_depo_manual'];
            $sum_wd_real = $data['sum_total_depo_manual'];
            $sum_wd_manual = $data['sum_total_wd_manual'];

            $count_all_status_depo = $data['count_total_req_depo'];
            $count_all_status_wd = $data['count_total_req_wd'];

            $count_settled = $data['count_bet_settled'];
            $total_settled = $data['sum_bet_settled'];

            $totalmember = $data['member_online'];
            $total_new_member_regis = $data['new_member_regis'];
            $total_new_member_deposit = $data['new_member_deposit'];

            $total_member_online = $data['new_total_member'];
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'totalnote' => 0,
            'is_maintenance' => $is_maintenance,
            'getdate' => $getdate ?? null,
            'fromdate' => $fromdate ?? null,
            'todate' => $todate ?? null,
            'cash_balance' => $cash_balance ?? null,
            'member_balance' => $member_balance ?? null,
            'total_balance' => $total_balance ?? null,
            'count_depo' => $count_depo ?? null,
            'count_wd' => $count_wd ?? null,
            'sum_depo' => $sum_depo ?? null,
            'sum_wd' => $sum_wd ?? null,
            'sum_depo_real' => $sum_depo_real ?? null,
            'sum_depo_manual' => $sum_depo_manual ?? null,
            'sum_wd_real' => $sum_wd_real ?? null,
            'sum_wd_manual' => $sum_wd_manual ?? null,
            'count_all_status_depo' => $count_all_status_depo ?? null,
            'count_all_status_wd' => $count_all_status_wd ?? null,
            'count_settled' => $count_settled ?? null,
            'total_settled' => $total_settled ?? null,
            'totalmember' => $totalmember ?? null,
            'total_new_member_regis' => $total_new_member_regis ?? null,
            'total_new_member_deposit' => $total_new_member_deposit ?? null,
            'total_member_online' => $total_member_online ?? null
        ]);
    }

    private function getDataDashboard($fromdate, $todate) {
        $cacheKey = "data_dashboard_{$fromdate}_to_{$todate}";
    
        $dataDashboard = Cache::remember($cacheKey, now()->addHours(4), function () use ($fromdate, $todate) {
            $dataRange = RekapDashboardDay::whereBetween('created_at', [$fromdate, $todate])->get();
    
            $summary = [
                'sum_cash_balance' => $dataRange->sum('sum_cash_balance'),
                'sum_member_balance' => $dataRange->sum('sum_member_balance'),
                'sum_total_balance' => $dataRange->sum('sum_total_balance'),
                'count_total_depo' => $dataRange->sum('count_total_depo'),
                'count_total_wd' => $dataRange->sum('count_total_wd'),
                'sum_all_total_depo' => $dataRange->sum('sum_all_total_depo'),
                'sum_all_total_wd' => $dataRange->sum('sum_all_total_wd'),
                'sum_total_depo' => $dataRange->sum('sum_total_depo'),
                'sum_total_depo_manual' => $dataRange->sum('sum_total_depo_manual'),
                'sum_total_wd' => $dataRange->sum('sum_total_wd'),
                'sum_total_wd_manual' => $dataRange->sum('sum_total_wd_manual'),
                'count_total_req_depo' => $dataRange->sum('count_total_req_depo'),
                'count_total_req_wd' => $dataRange->sum('count_total_req_wd'),
                'count_bet_settled' => $dataRange->sum('count_bet_settled'),
                'sum_bet_settled' => $dataRange->sum('sum_bet_settled'),
                'member_online' => $dataRange->sum('member_online'),
                'new_member_regis' => $dataRange->sum('new_member_regis'),
                'new_member_deposit' => $dataRange->sum('new_member_deposit'),
                'new_total_member' => $dataRange->sum('new_total_member'),
            ];
    
            return $summary;
        });
    
        return $dataDashboard;
    }

    private function getDataSettled($fromdate, $todate)
    {
        $sql = "
        SELECT count(A.id) as count_settled, sum(amount) as total_settled FROM(
        SELECT t.id, ts.status, ts.amount FROM transactions t
        JOIN (
            SELECT ts1.trans_id, ts1.status, ts2.amount FROM transaction_status ts1
            JOIN transaction_saldo ts2 ON ts1.id = ts2.transtatus_id
            WHERE (ts1.trans_id, ts1.created_at, ts1.urutan) IN (
                SELECT trans_id, MAX(created_at) AS max_created_at, MAX(urutan) AS max_urutan FROM transaction_status
                GROUP BY trans_id)
        ) ts ON t.id = ts.trans_id
        WHERE t.created_at >= ? AND t.created_at <= ? AND ts.status = 'Settled') as A";

        $results = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);
        return $results[0];
    }

    private function getDataNewmemberDepo($fromdate, $todate)
    {
        // $sql = "SELECT * FROM (
        // SELECT username, MIN(created_at) as created_at FROM depo_wd
        // where status = '1' and jenis IN ('DP', 'DPM')
        // group by username, DATE(created_at)) A
        // WHERE A.created_at >= ? AND A.created_at <= ?";

        $sql = "SELECT * FROM (
            SELECT username, DATE(created_at) as created_at FROM depo_wd
            WHERE created_at >= ? AND created_at <= ? AND status = '1'
            GROUP BY username, DATE(created_at)) A
            INNER JOIN (
                SELECT username, MIN(DATE(created_at)) as created_at FROM depo_wd
                WHERE status = '1'
                group by username
            ) B ON A.username = B.username AND A.created_at = B.created_at";

        $results = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);

        return count($results);
    }

    private function getDataMemberOnline($fromdate, $todate)
    {
        $sql = "SELECT count(username) as totalmo FROM (
            SELECT username FROM transactions
            WHERE created_at >= ? AND created_at <= ?
            group by username, DATE(created_at)) A";
        $result = DB::select($sql, ["$fromdate 00:00:00", "$todate 23:59:59"]);

        return $result[0]->totalmo;
    }
}
