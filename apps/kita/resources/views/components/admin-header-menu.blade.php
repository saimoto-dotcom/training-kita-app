<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{-- 左側：サイドバー開閉ボタン --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    {{-- 右側：ユーザー情報とログアウト --}}
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="far fa-user mr-1"></i>
                {{ auth('admin')->user()->last_name }}
                {{ auth('admin')->user()->first_name }} 様
            </a>

            {{-- アニメーションや位置ズレを防ぐための設定を追加 --}}
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item text-center" id="admin-logout-link">
                    <i class="fas fa-sign-out-alt mr-2"></i> ログアウト
                </a>

                <form id="admin-logout-form"
                    action="{{ route('admin.logout') }}"
                    method="GET"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>