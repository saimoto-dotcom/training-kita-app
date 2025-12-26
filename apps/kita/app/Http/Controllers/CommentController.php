<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\ArticleComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommentRequest $request): RedirectResponse
    {
        // バリデーション済みのデータのみを取得
        $validated = $request->validated();

        // article_comments テーブルに登録
        ArticleComment::create([
            'contents'   => $validated['comment'],
            'member_id'  => Auth::id(),
            'article_id' => $validated['article_id'],
        ]);

        // フラッシュメッセージ表示
        return redirect()
            ->route('articles.show', $validated['article_id'])
            ->with('success', 'コメントを投稿しました');
    }
}
