<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'id' => 1,
            'productsname' => 'Sports Book',
            'portfolio' => 'SportsBook',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 3,
            'productsname' => 'SBO Games',
            'portfolio' => 'Games',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 5,
            'productsname' => 'Virtual Sports',
            'portfolio' => 'VirtualSports',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 7,
            'productsname' => 'SBO Live Casino',
            'portfolio' => 'Casino',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'id' => 9,
            'productsname' => 'Seamless Game Provider',
            'portfolio' => 'SeamlessGame',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
