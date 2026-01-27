<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;



class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        Item::factory()->create([
            'name' => 'りんごジュース',
        ]);

        Item::factory()->create([
            'name' => 'バナナジュース',
        ]);

        Item::factory()->create([
            'name' => 'オレンジ',
        ]);

        $response = $this->get('/?keyword=ジュース');

        $response->assertStatus(200);

        $response->assertSee('りんごジュース');
        $response->assertSee('バナナジュース');
        $response->assertDontSee('オレンジ');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create([
            'name' => '赤いりんご',
            'user_id' => User::factory()->create()->id,
        ]);

        $item2 = Item::factory()->create([
            'name' => '青いバナナ',
            'user_id' => User::factory()->create()->id,
        ]);

        // 両方いいねする
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item2->id,
        ]);

        // 👇 tab + keyword を同時に指定
        $response = $this->get('/?tab=mylist&keyword=りんご');

        $response->assertSee('赤いりんご');
        $response->assertDontSee('青いバナナ');
    }

}


