<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleTagSearchRequest;
use App\Http\Requests\ArticleTagStoreRequest;
use App\Models\ArticleTag;
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
        // 並び順はモデルのスコープに委譲
        $query = ArticleTag::query()
            ->latestRegistered();

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

    public function edit(ArticleTag $articleTag)
    {
        return view('admin.article_tags.edit', compact('articleTag'));
    }
}
