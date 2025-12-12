<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;   // 商品モデル
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
{
    $items = Item::paginate(6);

    // キーワード検索
    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    // 並び替え対応
    if ($request->sort === 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort === 'price_desc') {
        $query->orderBy('price', 'desc');
    }

    $items = $query->paginate(6);

    return view('items.index', compact('items'));
}

    /**
     * 商品詳細ページ
     * URL: /item/{item_id}
     */
    public function show($item_id)
    {
        $items = Product::findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    /**
     * 商品購入ページ
     * URL: /purchase/{item_id}
     */
    public function purchase($item_id)
    {
        $product = Product::findOrFail($item_id);

        // 未ログインならログインページへ
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '購入するにはログインが必要です');
        }

        return view('items.purchase', compact('product'));
    }

    /**
     * 送付先住所変更ページ
     * URL: /purchase/address/{item_id}
     */
    public function changeAddress($item_id)
    {
        $product = Product::findOrFail($item_id);

        // 住所情報はユーザーのプロフィールから取得する想定
        $user = Auth::user();

        return view('items.address', compact('product', 'user'));
    }

    /**
     * 送付先住所の保存処理
     */
    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required',
            'address' => 'required',
            'name' => 'required',
        ]);

        $user = Auth::user();

        // ユーザーの住所情報更新
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->name = $request->name;
        $user->save();

        return redirect()->route('purchase', ['item_id' => $item_id])
            ->with('success', '住所を更新しました');
    }
}
