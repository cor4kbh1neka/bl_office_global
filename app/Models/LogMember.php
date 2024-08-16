<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMember extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'ipaddress', 'jenis', 'updated_at'];
    protected $table = 'log_member';
}
