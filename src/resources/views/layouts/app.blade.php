<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>COACHTECH フリマ</title>

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @stack('styles')
</head>
<body>

{{-- =========================
    ヘッダー
========================= --}}
<header class="header">
    <div class="header-inner">

        {{-- ロゴ --}}
        <div class="header-logo">
            COACHTECH
        </div>

        {{-- 検索 --}}
        <div class="header-search">
            <input
                type="text"
                placeholder="何をお探しですか？"
                class="search-input"
            >
        </div>

        {{-- メニュー --}}
        <nav class="header-nav">
            @auth
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>

                <a href="{{ route('mypage') }}">マイページ</a>
                <a href="{{ route('items.create') }}" class="sell-btn">出品</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">会員登録</a>
            @endauth
        </nav>

    </div>
</header>

{{-- メイン --}}
<main>
    @yield('content')
</main>

</body>
</html>
