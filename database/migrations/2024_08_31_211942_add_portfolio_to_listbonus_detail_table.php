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
        Schema::table('listbonus_detail', function (Blueprint $table) {
            $table->string('portfolio')->nullable()->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listbonus_detail', function (Blueprint $table) {
            $table->dropColumn('portfolio');
        });
    }
};
