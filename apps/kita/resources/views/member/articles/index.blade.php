@extends('layouts.app')

@section('title', '記事一覧')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')

@if($articles->isEmpty())
<div class="alert alert-danger">
    該当する記事はありません
</div>
@endif

<div class="row">
    @foreach($articles as $article)
    <div class="article-block col-12 mb-4">
        <!-- 投稿情報 -->
        <p class="mb-1 text-muted">
            {{ $article->member->name }} が {{ $article->created_at->format('Y年m月d日') }} に投稿
        </p>

        <!-- タイトル -->
        <h2 class="h5 mb-2">
            <a href="{{ route('articles.show', $article->id) }}"
                class="article-title">
                {{ $article->title }}
            </a>
        </h2>

        <!-- タグ -->
        <div class="tags">
            @foreach ($article->tags as $tag)
            <span class="tag">{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
    @endforeach

    <!-- ページネーション -->
    {{ $articles->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

@endsection