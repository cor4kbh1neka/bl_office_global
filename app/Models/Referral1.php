<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;

class Referral1 extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['upline', 'downline'];

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

    protected $table = 'referral_ae';

    public function depoReferrals()
    {
        return $this->hasMany(ReferralDepo1::class, 'upline', 'upline');
    }

    public function aktifReferrals()
    {
        return $this->hasMany(ReferralAktif1::class, 'upline', 'upline');
    }
}
