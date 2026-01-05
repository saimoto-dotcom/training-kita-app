<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
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
