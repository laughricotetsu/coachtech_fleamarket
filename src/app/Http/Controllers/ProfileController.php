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
        // バリデーション（例）
        $request->validate([
            'bio' => 'required|max:200',
        ]);

        // プロフィール更新
        Auth::user()->update([
            'bio' => $request->bio,
            'profile_completed' => true,
        ]);

        return redirect()->route('mypage');
    }
}
