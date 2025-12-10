<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Fleamarket') }}</title>

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    @stack('styles')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-left">
                <a href="{{ route('items.index') }}" class="logo">COACHTECH</a>
            </div>

            <form action="{{ route('items.index') }}" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="なにをお探しですか？">
            </form>

            <div class="header-right">
                @auth
                    <a href="{{ route('logout') }}">ログアウト</a>
                    <a href="{{ route('mypage.index') }}">マイページ</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}">ログイン</a>
                    <a href="{{ route('register') }}">会員登録</a>
                @endguest
                <a href="{{ route('sell.create') }}" class="sell-btn">出品</a>
            </div>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

</body>
</html>
