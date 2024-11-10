<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class RekapMemberOnline extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'username'
    ];

    protected $table = 'rekap_member_online';
}
