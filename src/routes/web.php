<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;

// 商品関連
Route::get('/', [ItemController::class, 'index']);                // 商品一覧（トップ）
Route::get('/item/{item_id}', [ItemController::class, 'show']);   // 商品詳細

// 出品
Route::get('/sell', [SellController::class, 'create']);           // 出品ページ
Route::post('/sell', [SellController::class, 'store']);           // 出品登録

// 購入
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index']); // 購入画面
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address']); // 住所変更

// マイページ
Route::get('/mypage', [MyPageController::class, 'index']);        // プロフィール + MyList
Route::get('/mypage/profile', [ProfileController::class, 'edit']); // プロフィール編集
Route::post('/mypage/profile', [ProfileController::class, 'update']); // 更新


