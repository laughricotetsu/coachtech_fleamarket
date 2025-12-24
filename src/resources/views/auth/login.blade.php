
@extends('layouts.auth')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="auth-wrapper">

    <div class="auth-card">

        <h2 class="auth-title">ログイン</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if ($errors->has('email'))
                <p class="error-text">ログイン情報が登録されていません</p>
            @endif


            {{-- メール --}}
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            {{-- パスワード --}}
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password">
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">
                ログインする
            </button>
        </form>

        <div class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </div>

    </div>

</div>
@endsection
