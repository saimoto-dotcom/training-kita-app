import './bootstrap';

window.addEventListener('load', () => {
    const modalEl = document.getElementById('passwordModal');
    // エラーメッセージ（text-danger）があるか確認
    if (modalEl && modalEl.querySelector('.text-danger')) {
        // Mix(Webpack)環境では bootstrap は window 直下か bootstrap 変数にあります
        const bootstrap = require('bootstrap'); 
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
});