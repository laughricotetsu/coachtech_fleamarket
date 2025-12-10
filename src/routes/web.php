<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;

// =====================
// トップ画面（商品一覧）
// =====================
Route::get('/', [ItemController::class, 'index'])->name('items.index');
// /?tab=mylist → index 内で判定してマイリスト表示


// =====================
// 認証（ログイン / 会員登録）
// =====================
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);


// =====================
// 商品詳細
// =====================
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');


// =====================
// 商品購入
// =====================
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.index');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

// 住所変更
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->name('purchase.address');
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');


// =====================
// 出品
// =====================
Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
Route::post('/sell', [SellController::class, 'store'])->name('sell.store');


// =====================
// マイページ（プロフィール / 購入履歴 / 出品履歴 / MyList）
// =====================
Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
// /mypage?page=buy
// /mypage?page=sell
// MyPageController で page パラメータを判定


// =====================
// プロフィール編集
// =====================
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
