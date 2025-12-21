<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        auth::user()->update([
        'name' => $request->name,
        'postal_code' => $request->postal_code,
        'address' => $request->address,
        'profile_completed' => true,
    ]);

    Auth::user()->update([
        'name' => $request->name,
        'profile_completed' => true,
    ]);

        return redirect()->route('items.index');
    }
}

