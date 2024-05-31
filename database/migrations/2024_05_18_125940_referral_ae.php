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
        Schema::create('referral_ae', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('upline');
            $table->string('downline');
            $table->timestamps();
        });

        // Menambahkan indeks pada kolom upline dan downline
        Schema::table('referral_ae', function (Blueprint $table) {
            $table->index('upline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_ae');
    }
};
