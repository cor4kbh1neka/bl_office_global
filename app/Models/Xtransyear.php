<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Xtransyear extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'bank', 'groupbank', 'username', 'count_dp', 'count_wd', 'sum_dp',  'sum_wd'];
    protected $table = 'xtransyear';
}
