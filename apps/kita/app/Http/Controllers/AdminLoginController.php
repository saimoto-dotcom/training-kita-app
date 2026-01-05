<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        // 管理者がすでにログインしている場合は管理画面へ
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // ログイン画面を表示
        return view('admin.login');
    }

    /**
     * Handle an admin login request.
     *
     * @param  \App\Http\Requests\AdminLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // 認証チェック（管理者ガード）
        if (! Auth::guard('admin')->attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors([
                    'auth' => 'メールアドレスまたはパスワードが違います',
                ]);
        }

        // セッションID再発行（セキュリティ対策）
        $request->session()->regenerate();

        // ログイン
        return redirect()->route('admin.dashboard');
    }

    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
