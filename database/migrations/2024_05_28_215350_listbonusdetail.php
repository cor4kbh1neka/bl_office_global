<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listbonus_detail', function (Blueprint $table) {
            $table->id();
            $table->string('listbonus_id');
            $table->string('username');
            $table->string('turnover');
            $table->string('winlose');
            $table->string('bonus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listbonus_detail');
    }
};
