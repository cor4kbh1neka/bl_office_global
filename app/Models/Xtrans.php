<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Xtrans extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'bank', 'groupbank', 'groupbankwd', 'username', 'count_dp', 'count_wd', 'sum_dp',  'sum_wd', 'sum_transaksi', 'sum_win'];
    protected $table = 'xtrans';
}
