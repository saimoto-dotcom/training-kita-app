<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // 検索ワード取得
        $search = trim($request->query('search', ''));

        // クエリ作成
        $articles = Article::with(['member', 'tags'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('contents', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(AppConsts::ARTICLES_PER_PAGE);

        // Blade に渡す
        return view('member.articles.index', compact('search', 'articles'));
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // 「タグ一覧」を表示
        $tags = ArticleTag::all();

        return view('member.articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request): \Illuminate\Http\RedirectResponse
    {
        // バリデーション済みのデータのみを取得
        $validated = $request->validated();

        // articles テーブルに登録
        $article = Article::create([
            'title'     => $validated['title'],
            'contents'  => $validated['contents'],
            'member_id' => Auth::id(),
        ]);
        // タグを中間テーブルに登録
        if (! empty($validated['tags'])) {
            $article->tags()->attach($validated['tags']);
        }

        // フラッシュメッセージ表示
        return redirect()
            ->route('articles.edit', $article->id)
            ->with('success', true);
    }

    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article): View
    {
        return view('member.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article): View
    {
        return view('member.articles.edit', compact('article'));
    }
}
