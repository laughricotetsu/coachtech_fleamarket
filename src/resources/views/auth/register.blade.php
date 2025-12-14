@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="auth-wrapper">

    <div class="auth-card">

        {{-- コンテンツ --}}
        <div class="auth-body">
            <h2 class="auth-title">会員登録</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- ユーザー名 --}}
                <div class="form-group">
                    <label>ユーザー名</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>

                {{-- メール --}}
                <div class="form-group">
                    <label>メールアドレス</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>

                {{-- パスワード --}}
                <div class="form-group">
                    <label>パスワード</label>
                    <input type="password" name="password">
                </div>

                {{-- 確認 --}}
                <div class="form-group">
                    <label>確認用パスワード</label>
                    <input type="password" name="password_confirmation">
                </div>

                <button type="submit" class="submit-btn">
                    登録する
                </button>
            </form>

            <div class="login-link">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </div>

    </div>

</div>
@endsection
