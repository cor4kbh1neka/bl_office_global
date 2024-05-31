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
        Schema::create('xreferral', function (Blueprint $table) {
            $table->id();
            $table->string('upline')->unique();
            $table->integer('total_downline')->default(0);
            $table->integer('downline_deposit')->default(0);
            $table->integer('downline_aktif')->default(0);
            $table->decimal('total_bonus', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xreferral');
    }
};
