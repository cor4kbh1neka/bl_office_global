<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_types', function (Blueprint $table) {
            $table->id();
            $table->integer('productid');
            $table->string('gametype');
            $table->string('gamename');
            $table->string('device');
            $table->timestamps();

            // $table->foreign('productid')
            //     ->references('id')->on('products')
            //     ->onUpdate('CASCADE')
            //     ->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_types');
    }
};
