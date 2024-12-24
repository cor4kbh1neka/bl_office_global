<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\DepoWd;
use App\Models\Member;
use App\Models\RekapDashboardDay;
use App\Models\RekapDashboardMonth;
use App\Models\RekapDashboardYear;
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
            $month = isset($request->month) ? $request->month : date('m');
            $year = isset($request->year) ? $request->year : date('Y');

            $data = $this->getDataDashboard($getdate, $fromdate, $todate, $month, $year);

            $cash_balance = $data['sum_cash_balance'];
            $member_balance = $data['sum_member_balance'];
            $total_balance = $data['sum_total_balance'];

            $count_depo = $data['count_total_depo'];
            $count_wd = $data['count_total_wd'];

            $sum_depo = $data['sum_all_total_depo'];
            $sum_wd = $data['sum_all_total_wd'];

            $sum_depo_real = $data['sum_total_depo'];
            $sum_depo_manual = $data['sum_total_depo_manual'];
            $sum_wd_real = $data['sum_total_wd'];
            $sum_wd_manual = $data['sum_total_wd_manual'];

            $count_all_status_depo = $data['count_total_req_depo'];
            $count_all_status_wd = $data['count_total_req_wd'];

            $count_settled = $data['count_bet_settled'];
            $total_settled = $data['sum_bet_settled'];

            $totalmember = $data['new_total_member'];
            $total_new_member_regis = $data['new_member_regis'];
            $total_new_member_deposit = $data['new_member_deposit'];

            $total_member_online = $data['member_online'];
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
            'total_member_online' => $total_member_online ?? null,
            'month' => $month,
            'year' => $year
        ]);
    }

    private function getDataDashboard($getdate, $fromdate, $todate, $month, $year) {
        
        if($getdate !== 'custom') {
            $cacheKey = "data_dashboard_{$fromdate}_to_{$todate}";
            
            $dataDashboard = Cache::remember($cacheKey, now()->addHours(4), function () use ($fromdate, $todate, $getdate) {
                $dataRange = RekapDashboardDay::whereBetween('created_at', [$fromdate . ' 00:00:00', $todate . ' 23:59:59'])->get();
                
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

                if($getdate == 'yesterday') {
                    $summary['new_total_member'] = Member::count('id');
                    $summary['sum_member_balance'] = Balance::sum('amount');
                }
        
                return $summary;
            });
        } elseif ($year != '' && $month == 'nomonth') {
            $cacheKey = "data_dashboard_{$year}";
        
            $dataDashboard = Cache::remember($cacheKey, now()->addHours(4), function () use ($year) {
                $dataRange = RekapDashboardYear::where('year', $year)->first();
        
                $summary = [
                    'sum_cash_balance' => 0,
                    'sum_member_balance' => 0,
                    'sum_total_balance' => 0,
                    'count_total_depo' => $dataRange->count_total_depo ?? 0,
                    'count_total_wd' => $dataRange->count_total_wd ?? 0,
                    'sum_all_total_depo' => $dataRange->sum_all_total_depo ?? 0,
                    'sum_all_total_wd' => $dataRange->sum_all_total_wd ?? 0,
                    'sum_total_depo' => $dataRange->sum_total_depo ?? 0,
                    'sum_total_depo_manual' => $dataRange->sum_total_depo_manual ?? 0,
                    'sum_total_wd' => $dataRange->sum_total_wd ?? 0,
                    'sum_total_wd_manual' => $dataRange->sum_total_wd_manual ?? 0,
                    'count_total_req_depo' => $dataRange->count_total_req_depo ?? 0,
                    'count_total_req_wd' => $dataRange->count_total_req_wd ?? 0,
                    'count_bet_settled' => $dataRange->count_bet_settled ?? 0,
                    'sum_bet_settled' => $dataRange->sum_bet_settled ?? 0,
                    'member_online' => $dataRange->member_online ?? 0,
                    'new_member_regis' => $dataRange->new_member_regis ?? 0,
                    'new_member_deposit' => $dataRange->new_member_deposit ?? 0,
                    'new_total_member' => $dataRange->new_total_member ?? 0,
                ];
                return $summary;
            });
        } else {
            $cacheKey = "data_dashboard_{$year}";
        
            $dataDashboard = Cache::remember($cacheKey, now()->addHours(4), function () use ($year, $month) {
                $dataRange = RekapDashboardMonth::where('year', $year)->where('month', $month)->first();
        
                $summary = [
                    'sum_cash_balance' => 0,
                    'sum_member_balance' => 0,
                    'sum_total_balance' => 0,
                    'count_total_depo' => $dataRange->count_total_depo ?? 0,
                    'count_total_wd' => $dataRange->count_total_wd ?? 0,
                    'sum_all_total_depo' => $dataRange->sum_all_total_depo ?? 0,
                    'sum_all_total_wd' => $dataRange->sum_all_total_wd ?? 0,
                    'sum_total_depo' => $dataRange->sum_total_depo ?? 0,
                    'sum_total_depo_manual' => $dataRange->sum_total_depo_manual ?? 0,
                    'sum_total_wd' => $dataRange->sum_total_wd ?? 0,
                    'sum_total_wd_manual' => $dataRange->sum_total_wd_manual ?? 0,
                    'count_total_req_depo' => $dataRange->count_total_req_depo ?? 0,
                    'count_total_req_wd' => $dataRange->count_total_req_wd ?? 0,
                    'count_bet_settled' => $dataRange->count_bet_settled ?? 0,
                    'sum_bet_settled' => $dataRange->sum_bet_settled ?? 0,
                    'member_online' => $dataRange->member_online ?? 0,
                    'new_member_regis' => $dataRange->new_member_regis ?? 0,
                    'new_member_deposit' => $dataRange->new_member_deposit ?? 0,
                    'new_total_member' => $dataRange->new_total_member ?? 0,
                ];
        
                return $summary;
            });
        }
        
        return $dataDashboard;
    }

    
}
