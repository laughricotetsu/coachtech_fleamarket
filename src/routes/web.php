<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AddressController;


// トップ画面（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', function () {
    $user = auth()->user();

    // 住所が未登録の場合
    if (empty($user->address)) {
        return redirect()->route('profile.edit');
    }

    // 登録済みなら商品一覧へ
    return redirect()->route('items.index');
    });

    // 商品購入
    Route::get('/purchase/{item}', [ItemController::class, 'purchase'])->name('purchase');

    Route::post('/item/{item}/purchase', [PurchaseController::class, 'store'])
    ->name('items.purchase');


    // 配送先住所変更（表示）
    Route::get('/purchase/{item}/address', [AddressController::class, 'edit'])
        ->name('purchase.address.edit');

    // 保存（session のみ）
    Route::post('/purchase/{item}/address', [AddressController::class, 'update'])
        ->name('purchase.address.update');

    // マイページ（プロフィール / 購入履歴 / 出品履歴 / MyList）
    Route::get('/mypage', [MyPageController::class, 'index'])
        ->name('mypage.index');

    // プロフィール編集
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/sell', [ItemController::class, 'create'])
    ->name('items.create');

    Route::post('/items', [ItemController::class, 'store'])
    ->name('items.store');

    Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])
    ->name('items.like');

    Route::post('/item/{item}/comment', [ItemController::class, 'addComment'])
        ->name('items.comment');


    // Stripe決済
    Route::post('/purchase/{item}', [PurchaseController::class, 'checkout'])
    ->name('purchase.checkout');

    // 決済成功
    Route::get('/purchase/success/{item}', [PurchaseController::class, 'success'])
    ->name('purchase.success');

    Route::get('/purchase/cancel/{item}', [PurchaseController::class, 'cancel'])
    ->name('purchase.cancel');

    Route::post('/purchase/payment/{item}', [PurchaseController::class, 'updatePayment'])
    ->name('purchase.payment.update');



});
