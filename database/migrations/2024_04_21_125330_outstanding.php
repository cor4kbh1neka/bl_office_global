<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outstanding', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transactionid');
            $table->string('transfercode');
            $table->string('username');
            $table->string('portfolio');
            $table->string('gametype');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outstanding');
    }
};
