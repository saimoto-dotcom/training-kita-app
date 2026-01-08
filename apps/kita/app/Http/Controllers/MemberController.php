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
        // 検索条件取得
        $name = $request->query('name', '');
        $email = $request->query('email', '');

        // クエリ作成
        $query = Member::query()
            ->orderBy('created_at', 'desc'); // 登録日順（新しい順）

        // 条件追加
        if ($name !== '') {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($email !== '') {
            $query->where('email', 'like', "%{$email}%");
        }

        // ページネーション
        $members = $query->paginate(AppConsts::ARTICLES_PER_PAGE)
            ->appends($request->query());

        return view('admin.users.index', compact('members'));
    }
}
