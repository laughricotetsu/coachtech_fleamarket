<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>COACHTECH</title>

    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @stack('styles')
</head>
<body>

    {{-- 認証画面専用ヘッダー --}}
    <header class="auth-header">
        <div class="auth-header-inner">
            <img src="{{ asset('item/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
        </div>
    </header>

    <main >
        @yield('content')
    </main>

</body>
</html>
