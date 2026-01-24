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
                'data' => [
                'user_id' => $userIds->random(),
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'color' => null,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'products/ArmaniMensClock.jpg',
                'condition' => '良好',
            ],
            'categories' => ['メンズ', 'ファッション'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'color' => null,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'products/HDDHardDisk.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            'categories' => ['家電'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => '玉ねぎ３束',
                'price' => 300,
                'brand' => 'なし',
                'color' => null,
                'description' => '新鮮な玉ねぎ３束のセット',
                'image_path' => 'products/onion.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            'categories' => ['食品'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'color' => null,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'products/leatherShoes.jpg',
                'condition' => '状態が悪い',
            ],
            'categories' => ['メンズ', 'ファッション'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'color' => null,
                'description' => '高性能なノートパソコン',
                'image_path' => 'products/Laptop.jpg',
                'condition' => '良好',
            ],
            'categories' => ['家電'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'color' => null,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'products/MusicMic.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            'categories' => ['家電'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'color' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'products/Purse.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            'categories' => ['ファッション','レディース'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'color' => null,
                'description' => '使いやすいタンブラー',
                'image_path' => 'products/Tumbler.jpg',
                'condition' => '状態が悪い',
            ],
            'categories' => ['キッチン'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'starbacks',
                'color' => null,
                'description' => '手動のコーヒーミル',
                'image_path' => 'products/CoffeeGrinder.jpg',
                'condition' => '良好',
            ],
            'categories' => ['キッチン'],
        ],
            [
                'data' => [
                'user_id' => $userIds->random(),
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'color' => null,
                'description' => '便利なメイクアップセット',
                'image_path' => 'products/makeupset.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            'categories' => ['コスメ'],
        ],
        ];

        foreach ($items as $itemDef) {

            $item = Item::create($itemDef['data']);

            $categoryIds = $categories
                ->only($itemDef['categories'])
                ->values();

            $item->categories()->attach($categoryIds);
        }

    }
}
