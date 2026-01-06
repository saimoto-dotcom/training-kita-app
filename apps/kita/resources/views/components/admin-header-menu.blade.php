<header class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">

        {{-- ロゴ：ルート名 admin_users.index を想定しています --}}
        <a class="navbar-brand" href="{{ route('admin_users.index') }}">
            Kita
        </a>

        {{-- メニュー --}}
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin_users.*') ? 'active' : '' }}"
                        href="{{ route('admin_users.index') }}">
                        管理者管理
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        会員管理
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('article_tags.*') ? 'active' : '' }}"
                        href="{{ route('article_tags.index') }}">
                        タグ管理
                    </a>
                </li>

            </ul>

            {{-- ログアウト：GETリクエストのリンク形式 --}}
            <div class="d-flex">
                <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm">
                    ログアウト
                </a>
            </div>
        </div>
    </div>
</header>