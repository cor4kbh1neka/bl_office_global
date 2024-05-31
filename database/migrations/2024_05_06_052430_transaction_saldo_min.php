<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_saldo_min', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaldo_id', 50)->required();
            $table->string('transactionid', 50)->required();
            $table->string('transfercode', 50)->required();
            $table->string('username', 50)->required();
            $table->decimal('amount', 8, 2)->default(0);
            $table->integer('jenis')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_saldo_min');
    }
};
