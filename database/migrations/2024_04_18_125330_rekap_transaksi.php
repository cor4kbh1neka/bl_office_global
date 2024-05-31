<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('count_depo_acc')->default(0);
            $table->integer('count_depo_all')->default(0);
            $table->integer('count_wd_acc')->default(0);
            $table->integer('count_wd_all')->default(0);
            $table->decimal('total_depo', 15, 2)->default(0);
            $table->decimal('total_depo_manual', 15, 2)->default(0);
            $table->decimal('total_wd', 15, 2)->default(0);
            $table->decimal('total_wd_manual', 15, 2)->default(0);
            $table->integer('count_bet_settled')->default(0);
            $table->decimal('total_bet_settled', 15, 2)->default(0);
            $table->integer('count_mo')->default(0);
            $table->integer('count_newregis')->default(0);
            $table->integer('count_newdepo')->default(0);
            $table->integer('count_total_member')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_transaksi');
    }
};
