<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- ロゴエリア --}}
    <a href="{{ route('admin_users.index') }}" class="brand-link">
        <i class="fas fa-shield-alt brand-image elevation-3 brand-icon"></i>
        <span class="brand-text font-weight-light"><b>KITA</b> ADMIN</span>
    </a>

    {{-- メニューエリア --}}
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu">

                {{-- 管理者管理 --}}
                <li class="nav-item">
                    <a href="{{ route('admin_users.index') }}"
                        class="nav-link {{ request()->is('admin_users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>管理者管理</p>
                    </a>
                </li>

                {{-- 会員管理 --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>会員管理</p>
                    </a>
                </li>

                {{-- タグ管理 --}}
                <li class="nav-item">
                    <a href="{{ route('article_tags.index') }}"
                        class="nav-link {{ request()->is('article_tags*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>タグ管理</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>