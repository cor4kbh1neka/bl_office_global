<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\DepoWd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentHour = date('H');
        $is_maintenance = false;
        if ($currentHour >= 0 && $currentHour < 1) {
            $is_maintenance = true;
        } else {
            $startOfYesterday = Carbon::yesterday()->startOfDay()->toDateTimeString(); 
            $endOfYesterday = Carbon::yesterday()->endOfDay()->toDateTimeString(); 
            
            $sum_cash_balance = Balance::sum('amount' );
            
            // $count_total_depo = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['DP', 'DPM'])->where('status', 1)->count();
            // $count_total_wd = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['WD', 'WDM'])->where('status', 1)->count();
            
            // $sum_total_depo = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['DP'])->where('status', 1)->sum('amount');
            // $sum_total_wd = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['WD'])->where('status', 1)->sum('amount');

            // $sum_total_depo_manual = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['DPM'])->where('status', 1)->sum('amount');
            // $sum_total_wd_manual = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['WDM'])->where('status', 1)->sum('amount');

            // $count_total_allreq_depo = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['WD', 'WDM'])->count();

            // $count_total_allreq_wd = DepoWd::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->whereIn('jenis', ['WD', 'WDM'])->count();
            






            

           

            // RekapDashboardDay::create([
            //     'sum_cash_balance' => $sum_cash_balance,
            //     'sum_member_balance' => $sum_cash_balance,
            //     'sum_total_balance' => $sum_cash_balance,
            //     'count_total_depo' => $count_total_depo,
            //     'count_total_wd' => $count_total_wd,
            //     'sum_all_total_depo' => $sum_total_depo + $sum_total_depo_manual,
            //     'sum_all_total_wd' => $sum_total_wd + $sum_total_wd_manual,
            //     'sum_total_depo' => $sum_total_depo,
            //     'sum_total_depo_manual' => $sum_total_depo_manual,
            //     'sum_total_wd' => $sum_total_wd,
            //     'sum_total_wd_manual' => $sum_total_wd_manual,
            //     'count_total_req_depo' => $count_total_allreq_depo,
            //     'count_total_req_wd' => $count_total_allreq_wd,

            //     'count_bet_settled' => $count_bet_settled,
            //     'sum_bet_settled' => $sum_bet_settled,
            //     'member_online' => $member_online,
            //     'new_member_regis'=> $new_member_regis,
            //     'new_member_deposit' => $new_member_deposit,
            //     'new_total_member' => $new_total_member

                    
                

                
                
            // ]);


            $getdate = $request->query('getdate');
            $fromdate = $request->query('fromdate');
            $todate = $request->query('todate');

            $response = Http::get(env('OLDDOMAIN') . 'api/olddata/' . $getdate);
            $data_old = $response->json();

            $cash_balance = isset($data_old["cash_balance"]) ? $data_old["cash_balance"] : 0;
            $member_balance = isset($data_old["member_balance"]) ? $data_old["member_balance"] : 0;
            $total_balance = isset($data_old["total_balance"]) ? $data_old["total_balance"] : 0;

            $count_depo = isset($data_old["count_depo"]) ? $data_old["count_depo"] : 0;
            $count_wd = isset($data_old["count_wd"]) ? $data_old["count_wd"] : 0;

            $sum_depo = isset($data_old["sum_depo"]) ? $data_old["sum_depo"] : 0;
            $sum_wd = isset($data_old["sum_wd"]) ? $data_old["sum_wd"] : 0;

            $sum_depo_real = isset($data_old["sum_depo_real"]) ? $data_old["sum_depo_real"] : 0;
            $sum_depo_manual = isset($data_old["sum_depo_manual"]) ? $data_old["sum_depo_manual"] : 0;
            $sum_wd_real = isset($data_old["sum_wd_real"]) ? $data_old["sum_wd_real"] : 0;
            $sum_wd_manual = isset($data_old["sum_wd_manual"]) ? $data_old["sum_wd_manual"] : 0;

            $count_all_status_depo = isset($data_old["count_all_status_depo"]) ? $data_old["count_all_status_depo"] : 0;
            $count_all_status_wd = isset($data_old["count_all_status_wd"]) ? $data_old["count_all_status_wd"] : 0;

            $count_settled = isset($data_old["count_settled"]) ? $data_old["count_settled"] : 0;
            $total_settled = isset($data_old["total_settled"]) ? $data_old["total_settled"] : 0;

            $totalmember = isset($data_old["totalmember"]) ? $data_old["totalmember"] : 0;
            $total_new_member_regis = isset($data_old["total_new_member_regis"]) ? $data_old["total_new_member_regis"] : 0;
            $total_new_member_deposit = isset($data_old["total_new_member_deposit"]) ? $data_old["total_new_member_deposit"] : 0;

            $total_member_online = isset($data_old["total_member_online"]) ? $data_old["total_member_online"] : 0;
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
