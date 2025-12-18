<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $categories = Category::pluck('id','name');

        if ($userIds->isEmpty() || $categories->isEmpty()) {

            return;
        }

        $items = [
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['ファッション'],
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'color' => null,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'products/ArmaniMensClock.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['家電'],
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'color' => null,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'products/HDDHardDisk.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['食品'],
                'name' => '玉ねぎ３束',
                'price' => 300,
                'brand' => 'なし',
                'color' => null,
                'description' => '新鮮な玉ねぎ３束のセット',
                'image_path' => 'products/onion.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['メンズ'],
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'color' => null,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'products/leatherShoes.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['家電'],
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'color' => null,
                'description' => '高性能なノートパソコン',
                'image_path' => 'products/Laptop.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['家電'],
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'color' => null,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'products/MusicMic.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['レディース'],
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'color' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'products/Purse.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['キッチン'],
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'color' => null,
                'description' => '使いやすいタンブラー',
                'image_path' => 'products/Tumbler.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['キッチン'],
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'starbacks',
                'color' => null,
                'description' => '手動のコーヒーミル',
                'image_path' => 'products/CoffeeGrinder.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => $categories['コスメ'],
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'color' => null,
                'description' => '便利なメイクアップセット',
                'image_path' => 'products/makeupset.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
