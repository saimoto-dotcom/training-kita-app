<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleTagSearchRequest;
use App\Http\Requests\ArticleTagStoreRequest;
use App\Http\Requests\ArticleTagUpdateRequest;
use App\Models\ArticleTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\ArticleTagSearchRequest  $request
     * @return \Illuminate\View\View
     */
    public function index(ArticleTagSearchRequest $request)
    {
        // クエリ作成
        $query = ArticleTag::query()
            // 登録日時順（新しい順）
            ->orderBy('created_at', 'desc');

        // 検索条件
        $name = $request->query('name', '');
        if ($name !== '') {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        // ページネーション
        $tags = $query
            ->paginate(AppConsts::ARTICLES_PER_PAGE)
            ->appends($request->query());

        return view('admin.article_tags.index', compact(
            'tags',
            'name'
        ));
    }

    /**
     * Show the form for creating a new tag.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.article_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleTagStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleTagStoreRequest $request)
    {
        // バリデーション済みデータのみ取得
        $validated = $request->validated();

        // DB登録処理
        $articleTag = ArticleTag::create([
            'name' => $validated['name'],
        ]);

        // 編集画面へリダイレクト + フラッシュメッセージ
        return redirect()
            ->route('article_tags.edit', $articleTag->id)
            ->with('success', '登録処理が完了しました');
    }

    /**
     * Show the form for editing the specified tag.
     *
     * @param \App\Models\ArticleTag $articleTag
     * @return \Illuminate\View\View
     */
    public function edit(ArticleTag $articleTag): View
    {
        return view('admin.article_tags.edit', compact('articleTag'));
    }

    /**
     * Update the specified tag in storage.
     *
     * @param \App\Http\Requests\ArticleTagUpdateRequest $request
     * @param \App\Models\ArticleTag $articleTag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleTagUpdateRequest $request, ArticleTag $articleTag): RedirectResponse
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 更新データを整形
        $data = [
            'name' => $validated['name'],
        ];

        // 更新実行
        $articleTag->update($data);

        // 成功時は同画面にリダイレクト＋フラッシュメッセージ
        return redirect()
            ->route('article_tags.edit', $articleTag->id)
            ->with('success', '更新処理が完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ArticleTag  $articleTag
     * @return RedirectResponse
     */
    public function destroy(ArticleTag $articleTag): RedirectResponse
    {
        // 記事との紐付けを削除（中間テーブル）
        $articleTag->articles()->detach();

        // 削除処理
        $articleTag->delete();

        // タグ一覧へリダイレクト
        return redirect()
            ->route('article_tags.index')
            ->with('success', '削除処理が完了しました');
    }
}
