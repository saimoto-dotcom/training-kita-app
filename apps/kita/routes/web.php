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

Route::get('/member_registration', [MemberRegisterController::class, 'create']);
Route::post('/member_registration', [MemberRegisterController::class, 'store']);

Route::get('/articles', function () {
    return view('member.articles.index');
});

Route::get('/login', [LoginController::class, 'create'])->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'destroy'])->middleware('auth');
