<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;


class MyListIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // 商品作成
        $likedItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '【テスト用】いいねした商品',
        ]);

        $notLikedItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '【テスト用】いいねしていない商品',
        ]);

        // いいね
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        // ログイン
        $this->actingAs($user);

        // マイリスト表示
        $response = $this->get('/?tab=mylist');

        // アサーション
        $response->assertStatus(200);
        $response->assertSee('【テスト用】いいねした商品');
        $response->assertDontSee('【テスト用】いいねしていない商品');
    }

    /** @test */
    public function マイリストの購入済み商品は_Sold_と表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        // 商品作成
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '【テスト用】購入済み商品',
        ]);

        // いいね
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 購入済みにする
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'price' => $item->price,
            'payment_method' => 'credit_card',
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('【テスト用】購入済み商品');
        $response->assertSee('Sold');
    }

    /** @test */
    public function 未ログインの場合_マイリストには何も表示されない()
    {
        // ユーザーと商品を作成
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '【テスト用】マイリスト商品',
            'user_id' => $user->id,
        ]);

        // いいねは存在する（でも未ログイン）
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 👈 あえて actingAs しない
        $response = $this->get('/?tab=mylist');

        // 商品が表示されていないこと
        $response->assertDontSee('【テスト用】マイリスト商品');
    }


}
