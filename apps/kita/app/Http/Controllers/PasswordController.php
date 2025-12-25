<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Show the password edit form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        /** @var \App\Models\Member $member */
        $member = Auth::user();

        return view('member.password.change', compact('member'));
    }

    /**
     * Update the authenticated user's password.
     *
     * @param  PasswordUpdateRequest  $request
     * @return RedirectResponse
     */
    public function update(PasswordUpdateRequest $request): RedirectResponse
    {
        /** @var Member $member */
        $member = auth()->user();

        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 更新
        $member->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/profile')
            ->with('success', 'パスワードを変更しました');
    }
}
