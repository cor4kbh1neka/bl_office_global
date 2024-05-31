<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'username', 'password', 'currency', 'min', 'max', 'maxpermatch', 'casinotablelimit', 'companykey', 'serverid'];
    protected $table = 'user_agents';
}
