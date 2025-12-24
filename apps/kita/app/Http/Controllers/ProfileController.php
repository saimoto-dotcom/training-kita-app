<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /** @var Member $member */
        $member = Auth::user();

        return view('member.profile.edit', compact('member'));
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var Member $member */
        $member = Auth::user();

        $member->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/profile')
            ->with('success', 'プロフィールを更新しました');
    }
}
