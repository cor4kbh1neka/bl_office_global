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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('persen_referral', 8, 2)->default(0)->after('ismaintenance');
            $table->string('jenis_bonus')->nullable()->after('pesen_referral');
            $table->decimal('min_lose_bet', 15, 2)->default(0)->after('jenis_bonus');
            $table->decimal('persen_bonus', 8, 2)->default(0)->after('min_lose_bet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['pesen_referral', 'jenis_bonus', 'min_lose_bet', 'persen_bonus']);
        });
    }
};
