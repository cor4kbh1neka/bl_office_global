<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_agents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->string('password');
            $table->string('currency');
            $table->string('min');
            $table->string('max');
            $table->string('maxpermatch');
            $table->string('casinotablelimit');
            $table->string('companykey');
            $table->string('serverid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_agents');
    }
};
