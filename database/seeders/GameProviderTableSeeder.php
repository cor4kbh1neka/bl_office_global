<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GameProviderTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['-1', 'Sbo'],
            ['2', 'CQNine'],
            ['5', 'Big Gaming'],
            ['10', 'Joker Gaming'],
            ['12', 'IONLC'],
            ['14', 'SBO Slots'],
            ['19', 'SaGaming'],
            ['22', 'Yggdrasil'],
            ['29', 'MicroGaming'],
            ['33', 'GreenDragon'],
            ['36', 'FlowGamingHub'],
            ['39', 'RedTiger'],
            ['47', 'GiocoPlus'],
            ['1009', 'MPoker'],
            ['1011', 'Digitain'],
            ['1015', 'AFBSports'],
            ['1019', 'YeeBet'],
            ['1021', 'OGLive'],
            ['1024', 'AFBCasino'],
            ['1026', 'Rich88'],
            ['1029', '568WinGames'],
            ['1031', 'Habanero'],
            ['1033', 'KingMidas'],
            ['1035', 'AsiaGaming'],
            ['1037', 'WE Casino'],
            ['1039', 'BigTimeGaming'],
            ['1041', '93connect'],
            ['1043', 'WCasino'],
            ['1045', 'MikiWorld'],
            ['1048', 'GameplayLiveCasino'],
            ['1050', 'BoleGaming'],
            ['1054', 'LambdaGaming'],
            ['1057', 'CC88'],
            ['1059', 'ClotPlay'],
            ['0', 'Wan Mei'],
            ['3', 'Pragmatic Play'],
            ['7', 'Sexy Gaming'],
            ['11', 'RealTimeGaming'],
            ['13', 'WorldMatch'],
            ['16', 'FunkyGames'],
            ['20', 'EvolutionGaming'],
            ['28', 'AllBet'],
            ['30', 'CQNineLC'],
            ['35', 'PGSoft'],
            ['38', 'PragmaticPlayCasino'],
            ['46', 'Sv388Cockfighting'],
            ['1000', 'ArcadiaGaming'],
            ['1010', 'YGR'],
            ['1012', 'TCGaming'],
            ['1016', 'AFBGaming'],
            ['1020', 'JiLiGaming'],
            ['1022', 'BTiSports'],
            ['1025', 'PlayTech Live Casino'],
            ['1027', 'MicroGaming LiveCasino'],
            ['1030', 'DreamGaming'],
            ['1032', 'RelaxGaming'],
            ['1034', 'AdvantPlay'],
            ['1036', 'Live22'],
            ['1038', 'Netent'],
            ['1040', 'NoLimitCity'],
            ['1042', 'KAGaming'],
            ['1044', 'PlayStar'],
            ['1046', 'FaChai'],
            ['1049', 'GameplayLottery'],
            ['1053', 'PandaSports'],
            ['1055', 'WGBCockfighting'],
            ['1058', 'JDB']
        ];

        // Memasukkan data ke dalam tabel game_providers
        foreach ($data as $provider) {
            DB::table('game_providers')->insert([
                'id' => $provider[0],
                'game' => $provider[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
