<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\AddressRequest;


class AddressController extends Controller
{
    public function edit(Item $item)
    {
        return view('address.edit',compact('item'));
    }

public function update(AddressRequest $request, Item $item)
{
    $validated = $request->validated();

    session([
        'purchase_address' => [
            'postal_code'      => $validated['postal_code'],
            'address'          => $validated['shipping_address'],
            'building'         => $validated['building'] ?? '',
        ]
    ]);

    return redirect()->route('purchase', $item);
}

}