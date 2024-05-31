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
        Schema::create('ref_depo_ae', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('upline');
            $table->string('downline');
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::table('ref_depo_ae', function (Blueprint $table) {
            $table->index('upline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_depo_ae');
    }
};
