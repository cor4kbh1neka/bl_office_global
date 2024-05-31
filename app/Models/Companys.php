<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companys extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'companykey'];
    protected $table = 'companys';
}
