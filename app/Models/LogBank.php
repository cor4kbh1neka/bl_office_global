<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBank extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'log'];
    protected $table = 'log_bank';
}
