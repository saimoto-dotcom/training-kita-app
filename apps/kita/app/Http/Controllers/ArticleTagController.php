<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\ArticleTagSearchRequest;
use App\Models\ArticleTag;

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

    public function create()
    {
        return view('admin.article_tags.create');
    }

    public function edit(ArticleTag $articleTag)
    {
        return view('admin.article_tags.edit', compact('articleTag'));
    }
}
