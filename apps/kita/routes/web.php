<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberRegisterController;
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

// 未ログインユーザーのみアクセス可能なルート
Route::middleware('guest')->group(function () {
    // ログイン画面表示
    Route::get('/login', [LoginController::class, 'create'])->name('login');

    // ログイン処理
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    // 会員登録画面表示
    Route::get('/member_registration', [MemberRegisterController::class, 'create'])->name('member.register');

    // 会員登録処理
    Route::post('/member_registration', [MemberRegisterController::class, 'store'])->name('member.register.store');
});

// ログイン済みユーザーのみアクセス可能なルート
Route::middleware('auth')->group(function () {
    // ログアウト処理
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

    // =========================
    // 記事
    // =========================
    // 記事一覧
    Route::get('/articles', [ArticleController::class, 'index'])
        ->name('articles');

    // 記事作成画面
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create');

    // 記事詳細
    Route::get('/articles/{article}', [ArticleController::class, 'show'])
        ->name('articles.show');

    // =========================
    // プロフィール
    // =========================
    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});
