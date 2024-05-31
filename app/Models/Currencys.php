<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencys extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'currency'];
    protected $table = 'currencys';
}
