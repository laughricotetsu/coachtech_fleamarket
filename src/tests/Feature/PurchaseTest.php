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
    public function 小計画面で変更が反映される()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'price' => 1000,
        ]);

        $this->actingAs($user);

        // 支払い方法を選択して保存
        $this->post(route('items.purchase', $item->id), [
            'payment_method' => 'credit_card',
        ]);

        // 小計画面を表示
        $response = $this->get(route('purchase', $item->id));

        $response->assertStatus(200);
        $response->assertSee('クレジットカード');
    }

    /** @test */
    public function 送付先住所変更画面で登録した住所が購入画面に反映される()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $this->actingAs($buyer);

        // 住所変更
        $this->post(route('purchase.address.update', $item->id), [
            'postal_code' => '123-4567',
            'shipping_address' => '東京都テスト区1-2-3',
            'building' => 'テストマンション101',
        ]);

        // 購入画面を表示
        $response = $this->get(route('purchase', $item->id));

        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('東京都テスト区1-2-3');
        $response->assertSee('テストマンション101');

        }



    }
