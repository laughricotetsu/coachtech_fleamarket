<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;


class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

    // 住所未登録ならプロフィール編集へ
        if ($user && $user->postal_code === null) {
            return redirect('/mypage/profile');
        }
    // 出品した商品
        $sellItems = Item::where('user_id', $user->id)->get();

    // 購入した商品
        $buyItems = Purchase::where('user_id', $user->id)
            ->with('item')
            ->get();

            return view('mypage.index', compact('user', 'sellItems', 'buyItems'));
        }

}