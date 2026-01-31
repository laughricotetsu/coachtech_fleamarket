<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Category;


class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 全商品を取得できる()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    /** @test */
    public function 購入済み商品は_Sold_と表示される()
    {
        $seller = User::factory()->create();
        $buyer  = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        // 購入履歴を作る
        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/items');

        $response->assertSee('Sold');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '[テスト用]自分の商品',
        ]);

        Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '[テスト用]他人の商品',
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertDontSee('[テスト用]自分の商品');
        $response->assertSee('[テスト用]他人の商品');
    }


    }
