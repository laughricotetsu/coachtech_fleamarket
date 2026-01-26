<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HelloTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHello()
    {
    User::factory()->create([
        'name'=>'aaa',
        'email'=>'bbb@ccc.com',
        'password'=>'test12345'
        ]);
        $this->assertDatabaseHas('users',[
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345'
            ]);
    }

    public function 名前が未入力の場合_バリデーションエラーが表示される()
{
    // 名前を送らずにPOSTする
    $response = $this->post('/register', [
        'name' => '', // 未入力
    ]);

    // バリデーションエラーがあること
    $response->assertSessionHasErrors([
        'name' => 'お名前を入力してください',
    ]);
}
    /** @test */
    public function メールアドレスが未入力の場合_バリデーションエラーが表示される()
{
    $response = $this->post('/register', [
        'name'  => 'テスト太郎',
        'email' => '', // ← 未入力
        'password' => 'password123',
    ]);

    // email のバリデーションエラーがあるか
    $response->assertSessionHasErrors([
        'email' => 'メールアドレスを入力してください',
    ]);
}
    public function パスワードが未入力の場合_バリデーションエラーが表示される()
{
    $response = $this->post('/register', [
        'name'  => 'テスト太郎',
        'email' => 'test@example.com',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertSessionHasErrors([
        'password' => 'パスワードを入力してください'
    ]);
}
    /** @test */
    public function パスワードが7文字以下の場合_バリデーションエラーが表示される()
{
    $response = $this->post('/register', [
        'name'  => 'テスト太郎',
        'email' => 'test@example.com',
        'password' => '1234567', // 7文字
        'password_confirmation' => '1234567',
    ]);

    $response->assertSessionHasErrors([
        'password' => 'パスワードは8文字以上で入力してください'
    ]);
}
    public function パスワードが確認用パスワードと一致しない場合_バリデーションエラーが表示される()
{
    $response = $this->post('/register', [
        'name'  => 'テスト太郎',
        'email' => 'test@example.com',

        // わざと不一致にする
        'password' => 'password123',
        'password_confirmation' => 'password999',
    ]);

    // password に対するエラーがあるか
    $response->assertSessionHasErrors([
        'password' => 'パスワードと一致しません'
    ]);
}

/** @test */
    public function 全ての項目が入力されている場合_会員情報が登録され_プロフィール設定画面に遷移される()
{
    // DBをテスト用にリセット
    $this->refreshDatabase();

    $response = $this->post('/register', [
        'name'  => 'テスト太郎',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    // プロフィール設定画面にリダイレクトされるか
    $response->assertRedirect('/mypage');

    // DBに登録されているか
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
}


}
