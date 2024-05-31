<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AllowedIpTableSeeder::class,
            CompanyTableSeeder::class,
            GameProviderTableSeeder::class,
            ProductsTableSeeder::class,
            GameTypeTableSeeder::class,
            UsersTableSeeder::class,
            TableCurrencySeeder::class,
            PersentaseTableSeeder::class,
            BetSettingSeeder::class,
            BonusTableSeeder::class,
            BonusPengecualianTableSeeder::class,
        ]);
    }
}
