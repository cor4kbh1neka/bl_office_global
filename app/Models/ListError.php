<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class ListError extends Model
{
    use HasFactory;

    protected $fillable = ['fungsi', 'pesan_error', 'keterangan'];
    protected $table = 'table_list_error';
}
