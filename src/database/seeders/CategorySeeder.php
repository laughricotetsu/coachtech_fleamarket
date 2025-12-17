<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        'ファッション',
        '家電・スマホ・カメラ',
        '食品・飲料・酒',
        'コスメ・美容',
        'インテリア・住まい',
        '本・音楽・ゲーム',
        'メンズ',
        'レディース',
        'キッチン・日用品',
        'オーディオ機器'
    ];

        foreach ($categories as $name) {
            Category::create([
            'name' => $name
        ]);
        }
    }
}
