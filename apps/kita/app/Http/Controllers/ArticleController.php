<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\RedirectResponse;
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
    public function store(ArticleRequest $request): RedirectResponse
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
            ->with('success', '記事投稿が完了しました');
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
    public function edit(Article $article): View|RedirectResponse
    {
        // 権限チェック（投稿者以外はリダイレクト）
        if ($article->member_id !== auth()->id()) {
            return redirect()
                ->route('articles')
                ->with('error', '編集権限がありません');
        }

        // DB から最新のタグ・記事情報を取得
        $article->refresh();
        $tags = ArticleTag::all();

        return view('member.articles.edit', compact('article', 'tags'))
            ->with('update', true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateArticleRequest  $request
     * @param  Article               $article
     * @return RedirectResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        // 権限チェック（投稿者以外はリダイレクト）
        if ($article->member_id !== auth()->id()) {
            return redirect()
                ->route('articles')
                ->with('error', '編集権限がありません');
        }

        // バリデーション済みデータ取得
        $validated = $request->validated();

        // 更新
        $article->update([
            'title'    => $validated['title'],
            'contents' => $validated['contents'],
        ]);

        // タグ更新
        if (array_key_exists('tags', $validated)) {
            $article->tags()->sync($validated['tags'] ?? []);
        }

        return redirect()
            ->route('articles.edit', $article)
            ->with('success', '記事編集が完了しました');
    }
}
