<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function ログインユーザーは商品を購入できる()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'price' => 1000,
        ]);

        $this->actingAs($buyer);

        $response = $this->post("/item/{$item->id}/purchase", [
            'payment_method' => 'credit_card',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'price' => 1000,
        ]);

        $response->assertRedirect(route('items.show', $item->id));
    }

    /** @test */
    public function 購入した商品は商品一覧画面にて「sold」と表示される()
        {
            $item = Item::factory()->create();

            Purchase::factory()->create([
                'item_id' => $item->id,
            ]);

            $response = $this->get('/');

            $response->assertSee('Sold');
        }

    /** @test */
    public function プロフィール画面に購入した商品が表示される()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'name' => '【テスト用】購入商品',
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'price' => $item->price,
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('【テスト用】購入商品');
    }

    }
