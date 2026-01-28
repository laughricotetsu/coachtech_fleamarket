<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Comment;
use App\Models\User;


class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品の基本情報が表示される()
    {
        $item = Item::factory()->create([
            'name' => '【テスト商品】カメラ',
            'brand' => 'テストブランド',
            'price' => 15000,
            'description' => 'これはテスト用の商品説明です',
            'condition' => '新品',
            'image_path' => 'test.jpg',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);

        $response->assertSee('【テスト商品】カメラ');
        $response->assertSee('テストブランド');
        $response->assertSee('¥15,000');
        $response->assertSee('これはテスト用の商品説明です');
        $response->assertSee('新品');

        // 画像はパス文字列が含まれていればOK
        $response->assertSee('test.jpg');
    }

    /** @test */
    public function コメント数が表示される()
    {
        $item = Item::factory()->create([
            'name' => 'コメントテスト商品',
        ]);

        // コメントを2件作成
        Comment::factory()->count(2)->create([
            'item_id' => $item->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);

        // コメント数「2」が表示されているか
        $response->assertSee('2');
    }

}
