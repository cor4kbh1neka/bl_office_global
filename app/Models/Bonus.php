<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_bonus', 'min', 'persentase'];
    protected $table = 'bonus';
}
