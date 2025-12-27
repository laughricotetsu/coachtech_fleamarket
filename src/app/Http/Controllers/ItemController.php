<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;   // 商品モデル
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user=Auth::user();
        if ($user){
             if($user && $user->hasVerifiedEmail()==false){
                return redirect()->route('verification.notice');
             }
            elseif ( $user->postal_code==null && $user->hasVerifiedEmail()){
               return redirect ('/mypage/profile');
            }
        }

        
        $items = Item::with('category')->get();
        return view('items.index', compact('items'));

        // キーワード検索
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え
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
    $item = Item::findOrFail($item_id);

    return view('items.show', compact('item'));
}


    /**
     * 商品購入ページ
     * URL: /purchase/{item_id}
     */
    public function purchase($item_id)
{
    $item = Item::findOrFail($item_id);

    if (!Auth::check()) {
        return redirect()->route('login')
            ->with('error', '購入するにはログインが必要です');
    }

    return view('items.purchase', compact('item'));
}

    public function store(Request $request)
{
    // ② 画像保存
    if ($request->hasFile('image')) {
        // storage/app/public/products に保存
        $path = $request->file('image')->store('products', 'public');
        // $path = "products/xxx.jpg"
        $validated['image'] = $path;
    }

    // ③ DB保存
    Item::create($validated);

    // ④ 一覧へリダイレクト
    return redirect()->route('items.index')
        ->with('success', '商品を登録しました');
}


    /**
     * 送付先住所変更ページ
     * URL: /purchase/address/{item_id}
     */
    public function changeAddress($item_id)
{
    $item = Item::findOrFail($item_id);
    $user = Auth::user();

    return view('items.address', compact('item', 'user'));
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
