<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionsDetail extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['trans_id', 'transactionid', 'status'];

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

    protected $table = 'transactions_detail';

    public function transactionstatus()
    {
        return $this->hasMany(TransactionStatus::class, 'trans_id');
    }
}
