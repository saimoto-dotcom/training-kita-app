<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberRegisterController;
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

// 会員登録
Route::get('/member_registration', [MemberRegisterController::class, 'create'])->name('member.register');
Route::post('/member_registration', [MemberRegisterController::class, 'store'])->name('member.register.store');

// 記事一覧
Route::get('/articles', function () {
    return view('member.articles.index');
})->name('articles');

// ログイン
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// ログアウト
Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});
