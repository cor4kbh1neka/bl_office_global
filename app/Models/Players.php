<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agents;

class Players extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'agentid', 'username', 'password', 'usergroup'];
    protected $table = 'user_players';

    public function agent()
    {
        return $this->hasOne(Agents::class, 'agentid');
    }
}
