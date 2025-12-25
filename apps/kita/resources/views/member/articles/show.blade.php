@extends('layouts.app')

@section('title', '記事詳細')

@section('content')
<div class="container">

    <h1>{{ $article->title }}</h1>

    <p class="text-muted">
        {{ $article->member->name }} が
        {{ $article->created_at->format('Y年m月d日') }} に投稿
    </p>

    <div class="mb-3">
        @foreach ($article->tags as $tag)
        <span class="badge bg-primary">{{ $tag->name }}</span>
        @endforeach
    </div>

    <div class="mb-4">
        {!! nl2br(e($article->contents)) !!}
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('articles.edit', $article) }}"
            class="btn btn-success">
            編集する
        </a>

        <form method="POST"
            action="{{ route('articles.destroy', $article) }}"
            onsubmit="return confirm('一度削除すると元に戻せません。よろしいですか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                削除する
            </button>
        </form>
    </div>

</div>
@endsection