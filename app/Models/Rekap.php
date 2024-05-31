<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'count_depo_acc', 'count_depo_all', 'count_wd_acc', 'count_wd_all', 'total_depo', 'total_depo_manual', 'total_wd', 'total_wd_manual', 'count_bet_settled', 'total_bet_settled', 'count_mo', 'count_newregis', 'count_newdepo', 'count_total_member',];
    protected $table = 'rekap_transaksi';
}
