<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationLog extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'status', 'message'];
    protected $table = 'migration_logs';
}
