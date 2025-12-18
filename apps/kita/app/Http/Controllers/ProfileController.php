<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面表示
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        return view('member.profile.edit', compact('user'));
    }
}
