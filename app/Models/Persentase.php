<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class Persentase extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'jenis', 'persentase', 'keterangan'];
    protected $table = 'persentase';
}
