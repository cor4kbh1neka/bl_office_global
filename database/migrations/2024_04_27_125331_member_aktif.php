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
        Schema::create('member_aktif', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->required();
            $table->string('referral', 50)->required();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('member_aktif');
    }
};
