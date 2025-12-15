<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberRegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('member.register');
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //　必須チェック
        $errors = [];

        if (! $request->filled('name')) {
            $errors['name'] = 'ユーザー名を入力してください。';
        }

        if (! $request->filled('email')) {
            $errors['email'] = 'メールアドレスを入力してください。';
        }

        if (! $request->filled('password')) {
            $errors['password'] = 'パスワードを入力してください。';
        }

        if (! $request->filled('password_confirmation')) {
            $errors['password_confirmation'] = 'パスワード（確認用）を入力してください。';
        }

        // パスワード不一致チェック
        if (
            $request->filled('password') &&
            $request->filled('password_confirmation') &&
            $request->input('password') !== $request->input('password_confirmation')
        ) {
            $errors['password'] = '入力されたパスワードが一致していません。';
        }

        // エラー表示
        if (! empty($errors)) {
            return back()
                ->withInput()
                ->withErrors($errors);
        }

        try {
            // DB登録処理
            $member = Member::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            // 自動ログイン処理
            Auth::login($member);

            return redirect('/articles');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // UNIQUE制約違反
                return back()
                    ->withInput()
                    ->withErrors([
                        'email' => 'すでに登録されているメールアドレスです。',
                    ]);
            }

            throw $e; // それ以外は本当のエラー
        }
    }
}
