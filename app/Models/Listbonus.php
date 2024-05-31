<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Listbonus extends Model
{
    use HasFactory;

    protected $fillable = ['no_invoice', 'periodedari', 'periodesampai', 'jenis_bonus', 'kecuali', 'total', 'status', 'processed_by'];
    protected $table = 'listbonus';
}
