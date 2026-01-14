@extends('layouts.app')

@section('title', '記事一覧')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')

{{-- フラッシュメッセージ --}}
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- 一括削除ボタン（ページ上部） --}}
@auth
<div class="mb-3">
    <button id="bulk-delete-btn"
        class="btn btn-danger"
        disabled>
        選択した記事を一括削除
    </button>
</div>
@endauth

@if($articles->isEmpty())
<div class="alert alert-danger">該当する記事はありません</div>
@endif

<div class="row">
    @foreach($articles as $article)
    {{-- 各記事行に一意なIDを付与（JSでの削除用） --}}
    <div class="article-block col-12 mb-4 d-flex align-items-start"
        data-article-id="{{ $article->id }}">

        {{-- チェックボックス（左側：自分の記事のみ） --}}
        @if (auth()->id() === $article->member_id)
        <div class="me-3 pt-1">
            <input type="checkbox"
                class="article-checkbox"
                value="{{ $article->id }}">
        </div>
        @endif

        <div class="flex-grow-1">
            <p class="mb-1 text-muted">
                {{ $article->member->name }} が
                {{ $article->created_at->format('Y年m月d日') }} に投稿
            </p>

            <h2 class="h5 mb-2">
                <a href="{{ route('articles.show', $article->id) }}"
                    class="article-title">
                    {{ $article->title }}
                </a>
            </h2>

            <div class="tags">
                @foreach ($article->tags as $tag)
                <span class="tag">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>

        {{-- 削除ボタン（右側：自分の記事のみ） --}}
        @if (auth()->id() === $article->member_id)
        <div class="ms-3">
            <button class="btn btn-outline-danger btn-sm delete-btn"
                data-id="{{ $article->id }}">
                削除
            </button>
        </div>
        @endif
    </div>
    @endforeach

    <!-- ページネーション -->
    {{ $articles->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
@endsection

@push('page-js')
{{-- 個別JS --}}
<script src="{{ asset('js/articles-index.js') }}" defer></script>
@endpush