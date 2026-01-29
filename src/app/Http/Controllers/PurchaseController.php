<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function checkout(PurchaseRequest $request, Item $item)
    {
        $validated = $request->validated();

        session([
            'validated_purchase' => $validated,
        ]);


        if ($item->user_id === auth()->id()) {
            return back()->with('error', '自分の商品は購入できません');
        }

        if ($item->is_sold) {
            return redirect()
                ->route('items.show', $item)
                ->with('error', 'この商品は売り切れました');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],

                    'unit_amount' => (int) $item->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => url('/purchase/success/' . $item->id),
            'cancel_url'  => url('/purchase/cancel/' . $item->id),
        ]);

        return redirect($session->url);
        }

    public function success(Item $item)
    {
        $user = auth()->user();

        $validated = session('validated_purchase');

        if (!$validated) {
            return redirect()
                ->route('items.show', $item)
                ->with('error', '購入情報が見つかりません');
        }

        $address = session('purchase_address') ?? [
            'postal_code'      => $user->postal_code,
            'shipping_address' => $user->address,
            'building'         => $user->building,
        ];

        Purchase::create([
            'user_id'          => $user->id,
            'item_id'          => $item->id,
            'price'            => $item->price,
            'payment_method'   => $validated['payment_method'],
            'postal_code'      => $validated['postal_code'],
            'shipping_address' => $validated['address'],
            'building'         => $address['building'],
        ]);

        $item->update(['is_sold' => true]);

        session()->forget([
            'purchase_address',
            'payment_method',
            'validated_purchase',
        ]);

        return redirect()->route('items.index')
            ->with('success', '購入が完了しました');
    }


    public function cancel(Item $item)
        {
            return redirect()->route('items.show', $item)
                ->with('error', '購入がキャンセルされました');
        }

    public function updatePayment(Request $request, Item $item)
        {
            $request->validate([
                'payment_method' => 'required',
            ]);

            session([
                'payment_method' => $request->payment_method
            ]);

            return redirect()->route('purchase', $item);
        }

        public function store(Request $request, Item $item)
        {
            $item->purchase()->create([
                'user_id' => auth()->id(),
                'price' => $item->price,
                'payment_method' => 'credit_card', // テスト用
            ]);

            return redirect()->route('items.show', $item->id);
        }


}
