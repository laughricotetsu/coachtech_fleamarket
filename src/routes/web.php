<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;


// トップ画面（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');


// 商品購入
Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('items.purchase');
Route::post('/purchase/{item_id}', [ItemController::class, 'store'])->name('items.purchase.store');

// 出品
Route::get('/sell', [SellController::class, 'create'])->name('items.create');
Route::post('/sell', [SellController::class, 'store'])->name('items.store');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');

// 送付先住所変更ページ
Route::get('/purchase/address/{item}', [ItemController::class, 'changeAddress'])
    ->name('items.address');

//送付先住所保存処理
Route::post('/purchase/address/{item}', [ItemController::class, 'updateAddress'])
    ->name('items.address.update');

// マイページ（プロフィール / 購入履歴 / 出品履歴 / MyList）
Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
Route::get('/mypage', fn () => view('mypage'))->name('mypage');
// /mypage?page=buy
// /mypage?page=sell
// MyPageController で page パラメータを判定

// プロフィール編集
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::middleware(['auth', 'verified', 'profile.completed'])->group(function () {
    Route::get('/mypage', ...);
});
