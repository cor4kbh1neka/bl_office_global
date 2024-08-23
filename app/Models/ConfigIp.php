<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigIp extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'ip'];
    protected $table = 'configip';
}
