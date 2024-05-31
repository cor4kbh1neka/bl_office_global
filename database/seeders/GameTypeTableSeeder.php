<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class GameTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('game_types')->insert([
            'productid' => 1,
            'gametype' => 0,
            'gamename' => 'Unknown(Use in GetBalance and Settle)
            GetBalance may use 0 as parameter to call,
            Settle please base on TransferCode to process only.',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 1,
            'gametype' => 1,
            'gamename' => 'Sports Book',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 1,
            'gametype' => 2,
            'gamename' => 'In Between',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 1,
            'gametype' => 3,
            'gamename' => '568 Sports Book',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 0,
            'gamename' => 'Unknown(Use in GetBalance and Settle)
            GetBalance may use 0 as parameter to call,
            Settle please base on TransferCode to process only.',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 161,
            'gamename' => 'Money Roll',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 161,
            'gamename' => 'Money Roll',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 201,
            'gamename' => 'Royal Baccarat',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 203,
            'gamename' => 'Royal Roulettle',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 204,
            'gamename' => 'Royal Blackjack',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 205,
            'gamename' => 'Royal Sic Bo',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 207,
            'gamename' => 'Royal 5 Box Blackjack',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 208,
            'gamename' => 'Dragon Bonus',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 511,
            'gamename' => 'Royal Baccarat',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 513,
            'gamename' => 'Royal Roulettle',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 514,
            'gamename' => 'Royal Blackjack',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 515,
            'gamename' => 'Royal Sic Bo',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 517,
            'gamename' => 'Royal 5 Box Blackjack',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 518,
            'gamename' => 'Dragon Bonus',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 3,
            'gametype' => 601,
            'gamename' => 'Live Bingo!',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 0,
            'gamename' => 'Unknown(Use in GetBalance and Settle)
            GetBalance may use 0 as parameter to call,
            Settle please base on TransferCode to process only.',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 201601,
            'gamename' => 'Virtual Football',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 201604,
            'gamename' => 'Virtual Basketball',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 201607,
            'gamename' => 'Virtual Euro Cup',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 201608,
            'gamename' => 'Virtual Asian Cup',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 201609,
            'gamename' => 'Virtual Champions Cup',
            'device' => 'Desktop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202601,
            'gamename' => 'Virtual Football',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202602,
            'gamename' => 'Virtual Basketball',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202607,
            'gamename' => 'Virtual Euro Cup',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202608,
            'gamename' => 'Virtual Asian Cup',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202609,
            'gamename' => 'Virtual Champions Cup',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 5,
            'gametype' => 202610,
            'gamename' => 'Bundesliga',
            'device' => 'Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 0,
            'gamename' => 'Baccarat',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 3,
            'gamename' => 'Roulette',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 5,
            'gamename' => 'SicBo',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 9,
            'gamename' => 'DragonTiger',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 10,
            'gamename' => 'MultipleTableBaccarat',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 11,
            'gamename' => 'BeautyBaccarat',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('game_types')->insert([
            'productid' => 7,
            'gametype' => 12,
            'gamename' => 'SpeedBaccarat',
            'device' => 'Desktop, Mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
