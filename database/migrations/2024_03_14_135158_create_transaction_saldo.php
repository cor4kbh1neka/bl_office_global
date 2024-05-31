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
        Schema::create('transaction_saldo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transtatus_id', 50)->required();
            $table->string('txnid', 50)->nullable();
            $table->string('jenis', 5)->required();
            $table->decimal('amount', 10, 2)->required();
            $table->integer('urutan')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_saldo');
    }
};
