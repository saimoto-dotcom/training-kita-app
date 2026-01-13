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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- ヘッダー --}}
        @auth
        <x-admin-header-menu />
        @endauth

        {{-- サイドメニュー --}}
        @auth
        @include('layouts.admin-sidebar')
        @endauth

        {{-- 各ページの中身 --}}
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    {{-- 共通JS --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- 各ページ固有のスクリプト --}}
    @stack('page-js')
</body>

</html>