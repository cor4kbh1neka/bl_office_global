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
        Schema::create('xdpwd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->required();
            $table->decimal('amount', 10, 2)->required();
            $table->string('keterangan', 20)->nullable();
            $table->string('jenis', 20)->required();
            $table->string('bank', 100)->nullable();
            $table->string('mbank', 100)->nullable();
            $table->string('mnamarek', 150)->nullable();
            $table->string('mnorek', 30)->nullable();
            $table->string('txnid', 50)->nullable();
            $table->decimal('balance', 10, 2);
            $table->integer('status');
            $table->string('approved_by', 50)->nullable();
            $table->boolean('isnotif')->default(false);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('xdpwd');
    }
};
