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
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

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

        $processedData = $this->oldData($request);

        return view('dashboard.index', array_merge([
            'title' => 'Dashboard',
            'data' => $data,
            'totalnote' => 0,
        ], $processedData));
    }
    public function oldData(Request $request)
    {
        $getdate = $request->query('getdate');
        $fromdate = $request->query('fromdate') ?? date('Y-m-d', strtotime('-1 day'));
        $todate = $request->query('todate') ?? date('Y-m-d', strtotime('-1 day'));

        $cash_balance = 0;
        $member_balance = Balance::sum('amount');
        $total_balance = $member_balance;

        $count_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->whereIn('jenis', ['DP', 'DPM'])
            ->count();

        $count_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->whereIn('jenis', ['WD', 'WDM'])
            ->count();

        $sum_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->whereIn('jenis', ['DP', 'DPM'])
            ->sum('amount');

        $sum_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->whereIn('jenis', ['WD', 'WDM'])
            ->sum('amount');

        $sum_depo_real = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->where('jenis', 'DP')
            ->sum('amount');

        $sum_depo_manual = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->where('jenis', 'DPM')
            ->sum('amount');

        $sum_wd_real = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->where('jenis', 'WD')
            ->sum('amount');

        $sum_wd_manual = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->where('status', 1)
            ->where('jenis', 'WDM')
            ->sum('amount');

        $count_all_status_depo = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->whereIn('jenis', ['DP', 'DPM'])
            ->count();

        $count_all_status_wd = DepoWd::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])
            ->whereIn('jenis', ['WD', 'WDM'])
            ->count();

        $count_settled = $this->getDataSettled($fromdate, $todate)->count_settled;
        $total_settled = $this->getDataSettled($fromdate, $todate)->total_settled ?? 0;

        $totalmember = Member::where('created_at', '<=', $todate . ' 23:59:59')->count();
        $total_new_member_regis = Member::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->count();
        $total_new_member_deposit = $this->getDataNewmemberDepo($fromdate, $todate);

        $total_member_online = $this->getDataMemberOnline($fromdate, $todate);

        return [
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
        ];
    }

    public function apiOldDataYesterday()
    {
        if (Redis::exists('yesterday')) {
            $data = json_decode(Redis::get('yesterday'), true);
        } else {
            return response()->json('gagal ambil cache');
        }
        return response()->json($data)->header('x-data-source', 'cache');
    }
    public function apiOldDataLastWeek()
    {
        if (Redis::exists('OneWeek')) {
            $data = json_decode(Redis::get('OneWeek'), true);
        } else {
            return response()->json('gagal ambil cache');
        }
        return response()->json($data)->header('x-data-source', 'cache');
    }
    public function apiOldDataLastMonth()
    {
        if (Redis::exists('OneMonth')) {
            $data = json_decode(Redis::get('OneMonth'), true);
        } else {
            return response()->json('gagal ambil cache');
        }
        return response()->json($data)->header('x-data-source', 'cache');
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

        $sql = "SELECT A.username
            FROM (
            SELECT username, DATE(created_at) as created_at FROM depo_wd
            where created_at >= ? AND created_at <= ? AND status = '1'
            group by username, DATE(created_at)
            ) A
            LEFT JOIN (
                SELECT username, DATE(MIN(created_at)) as created_at FROM depo_wd
                where status = '1'
                group by username
            ) B ON A.username = B.username 
            WHERE A.created_at = B.created_at;
            ";

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
