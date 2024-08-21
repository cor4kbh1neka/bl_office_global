<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HistoryTransaksi extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['username', 'invoice', 'refno', 'keterangan', 'portfolio', 'status', 'debit', 'kredit', 'balance'];

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
            $transaction->urutan = static::where('username', $transaction->username)->max('urutan') + 1;
        });
    }

    protected $table = 'history_transaksi';
}
