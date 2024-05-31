<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('referral')->nullable();
            $table->string('bank')->nullable();
            $table->string('namarek')->nullable();
            $table->string('norek')->nullable();
            $table->string('nohp')->nullable();
            $table->decimal('balance', 10, 2);
            $table->string('keterangan')->nullable();
            $table->string('ip_reg')->nullable();
            $table->string('ip_log')->nullable();
            $table->timestamp('lastlogin')->nullable();
            $table->string('domain')->nullable();
            $table->timestamp('lastlogin2')->nullable();
            $table->string('domain2')->nullable();
            $table->timestamp('lastlogin3')->nullable();
            $table->string('domain3')->nullable();
            $table->integer('min_bet')->default(0);
            $table->integer('max_bet')->default(0);
            $table->integer('status')->default(0);
            $table->boolean('is_notnew')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
