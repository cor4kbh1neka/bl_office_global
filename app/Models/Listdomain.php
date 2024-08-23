<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listdomain extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'link'];
    protected $table = 'listdomain';
}
