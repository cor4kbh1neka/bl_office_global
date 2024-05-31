<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('betting', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('companykey');
            $table->string('username');
            $table->decimal('amount', 10, 2);
            $table->string('transfercode');
            $table->string('transactionid');
            $table->string('bettime');
            $table->integer('producttype');
            $table->integer('gametype');
            $table->string('gameroundid');
            $table->string('gameperiodid');
            $table->string('orderdetail');
            $table->string('playerip');
            $table->string('gametypename');
            $table->string('gpid');
            $table->string('gameid');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('betting');
    }
};
