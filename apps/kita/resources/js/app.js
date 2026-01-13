import './bootstrap';
import 'admin-lte';
import '@fortawesome/fontawesome-free/js/all.js';

window.addEventListener('load', () => {
    const modalEl = document.getElementById('passwordModal');
    // エラーメッセージ（text-danger）があるか確認
    if (modalEl && modalEl.querySelector('.text-danger')) {
        // Mix(Webpack)環境では bootstrap は window 直下か bootstrap 変数にあります
        const bootstrap = require('bootstrap'); 
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    // 管理者ログアウトの制御（新しく追加する処理）
    const logoutLink = document.getElementById('admin-logout-link');
    const logoutForm = document.getElementById('admin-logout-form');

    if (logoutLink && logoutForm) {
        logoutLink.addEventListener('click', (event) => {
            event.preventDefault(); // aタグのデフォルト動作（遷移）を止めます
            logoutForm.submit();
        });
    }
});