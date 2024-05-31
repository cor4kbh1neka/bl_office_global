<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_providers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('game');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_providers');
    }
};
