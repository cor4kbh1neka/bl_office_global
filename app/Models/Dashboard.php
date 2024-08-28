<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;


    protected $fillable = ['nama'];
    protected $table = 'dashboard';
}
