<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberRegisterController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// =========================
// 記事（一覧・作成・詳細）
// ※ 静的パスは可変パラメータより先に定義する
// =========================

// 記事一覧（未ログイン可）
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles');

// 記事関連（ログイン必須）
Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    Route::post('/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});

// 記事詳細（未ログイン可）
Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');

// =========================
// 認証状態による画面制御
// =========================

// 未ログイン時のみアクセス可能（ログイン・会員登録）
Route::middleware('guest')->group(function () {

    // ログイン
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

    // 会員登録
    Route::get('/member_registration', [MemberRegisterController::class, 'create'])
        ->name('member.register');
    Route::post('/member_registration', [MemberRegisterController::class, 'store'])
        ->name('member.register.store');
});

// ログイン済みユーザーのみアクセス可能（アカウント関連）
Route::middleware('auth')->group(function () {

    // ログアウト
    Route::get('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    // プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // パスワード変更
    Route::get('/password/change', [PasswordController::class, 'edit'])
        ->name('password.edit');
    Route::put('/password/change', [PasswordController::class, 'update'])
        ->name('password.update');
});

// =========================
// 管理画面
// =========================
Route::middleware('guest:admin')->group(function () {
    // 管理者ログイン画面表示
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('admin.login');

    // 管理者ログイン処理
    Route::post('/admin/login', [AdminLoginController::class, 'login'])
        ->name('admin.login.store');
});

Route::middleware('auth:admin')->group(function () {
    // 管理者ログアウト
    Route::get('/admin/logout', [AdminLoginController::class, 'logout'])
        ->name('admin.logout');

    // 仮ページ
    Route::get('/admin/admin_users', function () {
        return view('admin.dashboard'); // 後で AdminUserController に置き換え
    })->name('admin.dashboard');
});
