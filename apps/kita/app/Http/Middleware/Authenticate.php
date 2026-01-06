<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            // URLが 'admin' または 'admin/*' の場合は管理者のログイン画面へ
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // それ以外は会員のログイン画面へ
            return route('login');
        }

        return '';
    }
}
