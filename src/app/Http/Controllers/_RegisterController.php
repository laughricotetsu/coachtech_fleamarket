<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
        {
        User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login');
        }

}
