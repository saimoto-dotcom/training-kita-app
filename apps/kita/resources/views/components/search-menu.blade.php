@push('page-css')
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
@endpush

<header class="header">
    <!-- 左: ロゴ -->
    <div class="header__left">
        <a href="{{ route('articles') }}" class="header__logo">
            Kita
        </a>
    </div>

    <!-- 中央: 検索フォーム（未ログインでもOK） -->
    <div class="header__center">
        <form action="{{ route('articles') }}" method="GET" class="header__search-form">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search for something">
            <button type="submit" class="header__search-btn">検索</button>
        </form>
    </div>

    <!-- 右: メニュー -->
    <div class="header__right">

        @auth
        <!-- ログイン中のみ -->
        <a href="{{ route('articles.create') }}" class="header__create-btn">
            記事を作成する
        </a>

        <div class="dropdown">
            <button
                class="header__profile-btn"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        プロフィール編集
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        ログアウト
                    </a>
                </li>
            </ul>
        </div>
        @endauth

        @guest
        <!-- 未ログイン時 -->
        <a href="{{ route('login') }}" class="header__login-btn">ログイン</a>
        <a href="{{ route('member.register') }}" class="header__register-btn">会員登録</a>
        @endguest

    </div>
</header>