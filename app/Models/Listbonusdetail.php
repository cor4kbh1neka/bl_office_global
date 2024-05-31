<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Listbonusdetail extends Model
{
    use HasFactory;

    protected $fillable = ['listbonus_id', 'username', 'turnover', 'winlose', 'bonus'];
    protected $table = 'listbonus_detail';
}
