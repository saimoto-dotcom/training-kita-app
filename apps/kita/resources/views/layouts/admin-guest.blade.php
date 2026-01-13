<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Kita Admin</title>

    {{-- AdminLTEとFontAwesomeを読み込みます --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('page-css')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Kita</b> Administrator Console
        </div>
        <div class="card card-outline card-primary">
            <div class="card-body login-card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('page-js')
</body>

</html>