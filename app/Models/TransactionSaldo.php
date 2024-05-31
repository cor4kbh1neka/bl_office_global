<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;

class TransactionSaldo extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transtatus_id', 'txnid', 'jenis', 'amount', 'ishutang', 'urutan'];

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

    protected $table = 'transaction_saldo';

    public function bettingstatus()
    {
        return $this->belongsTo(TransactionStatus::class, 'transtatus_id');
    }

    public function status()
    {
        return $this->hasOne(TransactionStatus::class, 'id', 'transtatus_id');
    }
}
