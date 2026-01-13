<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\JsonResponse;
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

        // DBからタグを取得
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

    /**
     * 指定した記事を削除する
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Article  $article
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Article $article)
    {
        // 権限チェック
        if ($article->member_id !== auth()->id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '削除権限がありません。',
                ], 403);
            }

            return redirect()->route('articles.show', $article)
                ->with('error', '削除権限がありません');
        }

        // 削除処理
        $article->delete();

        // Ajax（一覧画面など）からの場合
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '記事を削除しました。',
            ], 200);
        }

        // 普通のフォーム送信（詳細画面など）からの場合
        return redirect()->route('articles')
            ->with('success', '記事を削除しました');
    }

    /**
     * 選択された複数の記事を一括削除する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        // バリデーション（IDの配列が来ているかチェック）
        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:articles,id'],
        ]);

        $userId = auth()->id();
        $ids = $request->input('ids');

        // 自分の記事だけを対象にして一括削除
        $deletedCount = Article::whereIn('id', $ids)
            ->where('member_id', $userId)
            ->delete();

        // 削除された件数を含めて返事をする
        return response()->json([
            'success' => true,
            'message' => $deletedCount.'件の記事を削除しました。',
        ], 200);
    }
}
