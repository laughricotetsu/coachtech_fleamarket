<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'avatar_image' => null,
            'postal_code' => '012-3456',
            'address' => '札幌市白石区南郷7丁目南1番10号',
            'building' => null
        ]);
    }
}
