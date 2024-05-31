<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class BonusPengecualian extends Model
{
    use HasFactory;

    protected $fillable = ['portfolio', 'min_turnover', 'persentase'];
    protected $table = 'bonus_pengecualian';
}
