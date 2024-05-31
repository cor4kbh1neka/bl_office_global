<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;

class Transactions extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transactionid', 'transfercode', 'username', 'type', 'status'];

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

    protected $table = 'transactions';

    public function transactionstatus()
    {
        return $this->hasMany(TransactionStatus::class, 'trans_id', 'id');
    }



    // SALDO DAN STATUS
    public function transactionStatuses()
    {
        return $this->hasMany(TransactionStatus::class, 'trans_id', 'id')->orderBy('urutan', 'desc');
    }

    public function latestTransactionStatus()
    {
        return $this->hasOne(TransactionStatus::class, 'trans_id', 'id')->orderBy('urutan', 'desc')->latest();
    }

    public function latestTransactionSaldo()
    {
        return $this->hasOneThrough(
            TransactionSaldo::class,
            TransactionStatus::class,
            'trans_id',
            'transtatus_id',
            'id',
            'id'
        )->orderBy('urutan', 'desc')->latest();
    }
    // public function latestStatus()
    // {
    //     return $this->hasOne(TransactionStatus::class, 'trans_id', 'id')
    //         ->latest('created_at');
    // }
}
