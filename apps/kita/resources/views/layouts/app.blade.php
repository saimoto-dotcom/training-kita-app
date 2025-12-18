<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Laravel')</title>

    <!-- 共通 CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- 共通ヘッダー -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <!-- 個別ページ CSS -->
    @stack('page-css')

    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    {{-- 共通ヘッダー --}}
    @auth
    <x-search-menu />
    @endauth

    {{-- 各ページの中身 --}}
    <main class="container mt-5 pt-4">
        @yield('content')
    </main>
</body>

</html>