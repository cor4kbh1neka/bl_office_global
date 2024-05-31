<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bettingdetail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('betting_id');
            $table->string('sporttype');
            $table->string('markettype');
            $table->string('league');
            $table->string('match');
            $table->string('betoption');
            $table->string('kickoffTime');
            $table->string('ishalfwonlose');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bettingdetail');
    }
};
