<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;


class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィール画面に必要なユーザー情報が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar_image' => 'test.png',
            'postal_code' => '123-4567',
            'address' => '東京都テスト区1-2-3',
            'building' => 'テストマンション101',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');

    }

    /** @test */
    public function 必要項目が初期値として過去設定されている()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar_image' => 'test.png',
            'postal_code' => '123-4567',
            'address' => '東京都テスト区1-2-3',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都テスト区1-2-3');

    }


}