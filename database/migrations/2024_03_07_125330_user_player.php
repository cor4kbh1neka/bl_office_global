<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('agentid');
            $table->string('username');
            $table->string('password');
            $table->string('usergroup');
            $table->timestamps();

            $table->foreign('agentid')
                ->references('id')->on('user_agents')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_players');
    }
};
