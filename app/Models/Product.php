<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = ['productsname', 'portfolio', 'ismaintenance', 'persen_referral', 'jenis_bonus', 'min_lose_bet', 'persen_bonus'];
    protected $table = 'products';
}
