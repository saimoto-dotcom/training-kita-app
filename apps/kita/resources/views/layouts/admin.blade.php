<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Administrator')</title>

    <!-- 共通 CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- 管理者用 CSS -->
    @stack('page-css')

    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    {{-- 管理者共通ヘッダー --}}
    @auth
    <x-admin-header-menu />
    @endauth

    {{-- 各ページの中身 --}}
    <main class="admin-main">
        {{-- フラッシュメッセージ --}}
        @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>
</body>

</html>