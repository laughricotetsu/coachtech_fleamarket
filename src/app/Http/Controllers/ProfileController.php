<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    /**
     * プロフィール編集画面
     */
    public function edit()
    {
        return view('mypage.edit_profile');
    }

    /**
     * プロフィール更新処理
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

    // 画像アップロード
    if ($request->hasFile('avatar_image')) {
        $path = $request->file('avatar_image')->store('avatars', 'public');
        $user->avatar_image = $path;
    }

    $user->update([
        'name'        => $request->name,
        'postal_code' => $request->postal_code,
        'address'     => $request->address,
        'building'    => $request->building,
        'profile_completed' => true,
    ]);

        return redirect()->route('items.index')
            ->with('success', 'プロフィールを更新しました');
    }
}

