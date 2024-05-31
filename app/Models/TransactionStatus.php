<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class TransactionStatus extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['trans_id', 'status', 'urutan'];

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

            // Menggunakan first() untuk mendapatkan model tunggal, bukan koleksi
            $lastTransaction = self::where('trans_id', $transaction->trans_id)
                ->orderBy('urutan', 'desc')
                ->first();

            if ($lastTransaction) {
                $transaction->urutan = $lastTransaction->urutan + 1;
            } else {
                $transaction->urutan = 1;
            }
        });
    }

    protected $table = 'transaction_status';

    public function transactions()
    {
        return $this->belongsTo(Transactions::class, 'trans_id', 'id');
    }

    public function transactionsaldo()
    {
        return $this->hasMany(TransactionSaldo::class, 'transtatus_id', 'id');
    }
}
