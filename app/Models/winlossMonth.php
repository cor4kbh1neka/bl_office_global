<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winlossMonth extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'count', 'month', 'year', 'deposit', 'withdraw'];
    protected $table = 'winloss_month';
}
