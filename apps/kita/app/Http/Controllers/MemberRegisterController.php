<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRegisterRequest;
use App\Models\Member;
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
     * @param  \App\Http\Requests\MemberRegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MemberRegisterRequest $request)
    {
        // バリデーション済みデータのみ取得
        $validated = $request->validated();

        // DB登録処理
        $member = Member::create([
            'name' => trim($validated['name']),
            'email' => trim($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);
        // 自動ログイン処理
        Auth::login($member);

        return redirect()->route('articles');
    }
}
