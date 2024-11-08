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
        Schema::create('rekap_dashboard_months', function (Blueprint $table) {
            $table->id();
            $table->decimal('sum_cash_balance', 15, 2)->default(0);
            $table->decimal('sum_member_balance', 15, 2)->default(0);
            $table->decimal('sum_total_balance', 15, 2)->default(0);
            $table->integer('count_total_depo')->default(0);
            $table->integer('count_total_wd')->default(0);
            $table->decimal('sum_all_total_depo', 15, 2)->default(0);
            $table->decimal('sum_all_total_wd', 15, 2)->default(0);
            $table->decimal('sum_total_depo', 15, 2)->default(0);
            $table->decimal('sum_total_depo_manual', 15, 2)->default(0);
            $table->decimal('sum_total_wd', 15, 2)->default(0);
            $table->decimal('sum_total_wd_manual', 15, 2)->default(0);
            $table->integer('count_total_req_depo')->default(0);
            $table->integer('count_total_req_wd')->default(0);
            $table->integer('count_bet_settled')->default(0);
            $table->decimal('sum_bet_settled', 15, 2)->default(0);
            $table->integer('member_online')->default(0);
            $table->integer('new_member_regis')->default(0);
            $table->integer('new_member_deposit')->default(0);
            $table->integer('new_total_member')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_dashboard_months');
    }
};
