<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


// トップ画面（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::post('/register', [RegisterController::class, 'store'])->name('register');
// 商品購入
Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('items.purchase');
Route::post('/purchase/{item_id}', [ItemController::class, 'store'])->name('items.purchase.store');


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

/*
|--------------------------------------------------------------------------
| メール認証関連
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 認証案内画面
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // 認証リンククリック時
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        // 初回プロフィールへ
        return redirect()->route('profile.edit');
    })->middleware(['signed'])->name('verification.verify');

    // 認証メール再送
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
});

