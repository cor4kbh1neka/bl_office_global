<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class RekapDashboardYear extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'sum_cash_balance', 'sum_member_balance', 'sum_total_balance', 'count_total_depo', 'count_total_wd', 'sum_all_total_depo', 'sum_all_total_wd', 'sum_total_depo', 'sum_total_depo_manual', 'sum_total_wd', 'sum_total_wd_manual', 'count_total_req_depo', 'count_total_req_wd', 'count_bet_settled', 'sum_bet_settled', 'member_online', 'new_member_regis', 'new_member_deposit', 'new_total_member'];

    protected $table = 'rekap_dashboard_years';
}
