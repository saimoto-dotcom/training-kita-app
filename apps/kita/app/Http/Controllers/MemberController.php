<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\MemberSearchRequest;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * 会員一覧を表示します。
     *
     * @param \App\Http\Requests\MemberSearchRequest $request
     * @return \Illuminate\View\View
     */
    public function index(MemberSearchRequest $request)
    {
        // モデルで定義したスコープを呼び出す
        $query = Member::query()
            ->latestRegistered();

        // ユーザー名での検索
        $query->when(
            $request->filled('name'),
            fn ($q) => $q->where('name', 'like', "%{$request->name}%")
        );

        // メールアドレスでの検索
        $query->when(
            $request->filled('email'),
            fn ($q) => $q->where('email', 'like', "%{$request->email}%")
        );

        $members = $query->paginate(AppConsts::ARTICLES_PER_PAGE)
            ->appends($request->query());

        return view('admin.users.index', compact('members'));
    }
}
