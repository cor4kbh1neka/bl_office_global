<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBackup extends Model
{
    use HasFactory;

    protected $fillable = ['target_month', 'status', 'message'];
    protected $table = 'migration_logs';
}
