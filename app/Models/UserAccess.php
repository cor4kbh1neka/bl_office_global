<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class UserAccess extends Model
{
    use HasFactory;

    protected $fillable = ['name_access', 'deposit', 'withdraw', 'manual_transaction', 'history_coin', 'member_list',  'referral', 'history_game', 'member_outstanding', 'history_transaction', 'report', 'bank', 'memo', 'agent', 'analytic', 'content', 'apk_setting', 'memo_other'];
    protected $table = 'user_access';

    public function user()
    {
        return $this->belongsTo(User::class, 'divisi', 'name_access');
    }
}
