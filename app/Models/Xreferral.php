<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Xreferral extends Model
{
    use HasFactory;

    protected $fillable = ['upline', 'total_downline', 'downline_deposit', 'downline_aktif', 'total_bonus'];
    protected $table = 'xreferral';
}
