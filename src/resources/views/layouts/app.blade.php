<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>COACHTECH フリマ</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a href="{{ route('items.index') }}" class="header-logo-link">
                <img src="{{ asset('item/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>
        </div>

        <form method="GET" action="{{ route('items.index') }}" class="header-search">
            <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="なにをお探しですか？">
        </form>


        {{-- メニュー --}}
        <nav class="header-nav">
            @auth
                {{-- ログアウト --}}
                <form method="POST" action="{{ route('logout') }}" class="header-nav-item">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>

                {{-- マイページ --}}
                <a href="{{ route('mypage.index') }}" class="header-nav-item">
                    マイページ
                </a>

                {{-- 出品 --}}
                <a href="{{ route('items.create') }}" class="header-nav-item sell-btn">
                    出品
                </a>
            @else
                <a href="{{ route('login') }}" class="header-nav-item">ログイン</a>
                <a href="{{ route('register') }}" class="header-nav-item">会員登録</a>
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
