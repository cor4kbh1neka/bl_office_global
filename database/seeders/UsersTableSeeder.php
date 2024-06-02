<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin L21',
            'username' => 'BL4D4unz#21',
            'divisi' => 'superadmin',
            'password' => Hash::make('1m0Rt4ALz@@!!'),
            'image' => '',
            // 'isapk' => true,
            // 'isdata' => true,
            // 'istransaction' => true,
            // 'isconfig' => true,
            // 'isconfigadmin' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
