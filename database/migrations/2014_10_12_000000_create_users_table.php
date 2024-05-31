<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->required();
            $table->string('username', 50)->unique()->required();
            $table->string('divisi', 20)->required();
            $table->string('password')->required();
            $table->string('image')->nullable();
            // $table->boolean('isapk')->default(false);
            // $table->boolean('isdata')->default(false);
            // $table->boolean('istransaction')->default(false);
            // $table->boolean('isconfig')->default(false);
            // $table->boolean('isconfigadmin')->default(false);
            $table->integer('status')->default(1);
            $table->timestamp('last_login')->nullable();
            $table->string('ip_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
