<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\AddressRequest;


class ItemController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

        // クエリビルダ初期化
        $query = Item::query()->with(['categories', 'purchase']);


        // 🔽 自分が出品した商品は除外
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        // マイリスト（いいね一覧）
        if ($request->tab === 'mylist' && Auth::check()) {
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }
        elseif($request->tab === 'mylist'){
            $query->whereRaw('0 = 1');
        }

        // キーワード検索
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 取得
        $items = $query->get();

        return view('items.index', compact('items'));
    }
    /**
     * 商品詳細ページ
     * URL: /item/{item_id}
     */
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);

        $item = Item::withCount(['likes', 'comments'])
        ->with(['comments.user'])
        ->withExists([
        'likes as is_liked' => function ($q) {
            $q->where('user_id', auth()->id());
        }
        ])
        ->findOrFail($item_id);


        $liked = auth()->check()
        ? $item->likes()->where('user_id', auth()->id())->exists()
        : false;

        return view('items.show', compact('item','liked'));
    }


    public function toggleLike(Item $item)
    {
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'is_liked' => $liked,
            'likes_count' => $item->likes()->count(),
        ]);
    }

    public function addComment(CommentRequest $request, Item $item)
    {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->validated()['comment'],
        ]);

        return redirect()->route('items.show', $item->id);
    }

    /**
     * 商品購入ページ
     * URL: /purchase/{item_id}
     */
    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', '購入するにはログインが必要です');
        }

        $purchase = Purchase::where('item_id', $item->id)
        ->where('user_id', $user->id)
        ->first();

        return view('purchase.create', compact('item', 'user', 'purchase'));
    }


    /**
     * 送付先住所変更ページ
     * URL: /purchase/address/{item_id}
     */
    public function changeAddress($item_id)
        {
            $item = Item::findOrFail($item_id);
            $user = Auth::user();

            return view('address.edit', compact('item', 'user'));
        }


    /**
     * 送付先住所の保存処理
     */
    public function updateAddress(AddressRequest $request, $item)
        {
            $request->user()->update([
                'postal_code' => $request->postal_code,
                'shipping_address' => $request->shipping_address,
                'building' => $request->building,
            ]);

            return redirect()->route('purchase', ['item' => $item]);
        }

    public function create()
        {
            $categories = Category::all();

            return view('items.create', compact('categories'));
        }

    public function store(ExhibitionRequest $request)
        {
            $validated = $request->validated();

            // 画像保存
            $imagePath = $request->file('image')->store('items', 'public');

            // 商品保存
            $item = Item::create([
                'user_id'     => auth()->id(),
                'name'        => $validated['name'],
                'brand'       => $request->brand,
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'condition'   => $validated['condition'],
                'image_path'  => $imagePath,
            ]);

            // カテゴリー紐付け
            $item->categories()->sync($validated['categories']);

            return redirect()->route('items.index')
                ->with('success', '商品を出品しました');
        }
    public function mylist()
    {
        if (!auth()->check()) {
            return view('items.index', ['items' => collect()]);
        }

        $items = Item::whereHas('likes', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->with('purchase') // Sold 判定用
        ->get();

        return view('items.index', compact('items'));
    }


}


