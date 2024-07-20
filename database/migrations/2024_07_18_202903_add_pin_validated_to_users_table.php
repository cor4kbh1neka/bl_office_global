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
        Schema::table('users', function (Blueprint $table) {
            $table->string('pin', 255)->default('$2y$12$Wzii5ncZHu3tqzzAD/I1bu.xmPtsILAds/h58B5VYzP.I6na1q4fG')->after('remember_token');
            $table->integer('pin_attempts')->default(0)->after('pin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pin');
            $table->dropColumn('pin_attempts');
        });
    }
};
