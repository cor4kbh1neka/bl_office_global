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
        Schema::table('listbonus', function (Blueprint $table) {
            $table->text('detail_bonus')->nullable()->after('jenis_bonus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listbonus', function (Blueprint $table) {
            $table->dropColumn('detail_bonus');
        });
    }
};
