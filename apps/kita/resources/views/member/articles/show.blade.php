@extends('layouts.app')

@section('title', '記事詳細')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')
<div class="mt-n5">
    {{-- フラッシュメッセージ --}}
    @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    {{-- cardに自作クラスを追加 --}}
    <div class="card p-4 overflow-hidden article-details-card">

        {{-- ===== 記事ヘッダー（横並び設定） ===== --}}
        <div class="article-header mb-4 d-flex justify-content-between align-items-start">

            {{-- 左側：タイトルと投稿者情報 --}}
            <div>
                <h1 class="mb-0">
                    {{ $article->title }}
                </h1>
                <p class="text-muted mt-2 mb-0">
                    {{ $article->member->name }} が {{ $article->created_at->format('Y年m月d日') }} に投稿
                </p>
            </div>

            {{-- 右側：ボタン群 --}}
            @if (Auth::check() && (int) Auth::id() === (int) $article->member_id)
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('articles.destroy', $article) }}"
                    onsubmit="return confirm('一度削除すると元に戻せません。よろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-article-submit btn-danger">削除する</button>
                </form>
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-article-submit btn-success">編集する</a>
            </div>
            @endif
        </div>

        {{-- ===== タグ ===== --}}
        <div class="mb-4">
            @foreach ($article->tags as $tag)
            <span class="tag">{{ $tag->name }}</span>
            @endforeach
        </div>

        {{-- ===== 本文 ===== --}}
        <div class="mb-5">
            {!! nl2br(e($article->contents)) !!}
        </div>

        {{-- ===== コメント一覧 ===== --}}
        <h3 class="comment-section-title full-width-edge">コメント</h3>

        @forelse ($article->comments as $comment)
        <div class="mb-3">
            <p class="mb-1 text-muted">
                {{ $comment->member?->name ?? '退会ユーザー' }} が {{ $comment->created_at->format('Y年m月d日') }} に投稿
            </p>
            <div>
                {!! nl2br(e($comment->contents)) !!}
            </div>
        </div>

        {{-- 三項演算子で、最後のみクラスを付与 --}}
        <hr class="{{ $loop->last ? 'full-width-edge' : '' }}">
        @empty
        <p class="text-muted">コメントはまだありません。</p>
        @endforelse

        {{-- ===== コメント投稿 ===== --}}
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf

            <input type="hidden" name="article_id" value="{{ $article->id }}">

            <div class="d-flex gap-2 align-items-start">
                <textarea
                    name="comment"
                    class="form-control form-control--green flex-grow-1"
                    rows="4"
                    required
                    maxlength="1000"
                    placeholder="コメントを入力"></textarea>

                <button type="submit" class="btn btn-outline-success btn-rounded align-self-end">
                    コメント
                </button>
            </div>
        </form>
    </div>
</div>
@endsection