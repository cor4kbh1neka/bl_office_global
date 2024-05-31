<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;

class Member extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['username', 'referral', 'bank', 'namarek', 'nohp', 'norek', 'balance', 'keterangan', 'ip_reg', 'ip_log', 'last_login', 'domain', 'lastlogin2', 'domain2', 'lastlogin3', 'domain3', 'min_bet', 'max_bet', 'status', 'is_notnew', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->id = Str::uuid()->toString();
        });
    }

    protected $table = 'member';
}
