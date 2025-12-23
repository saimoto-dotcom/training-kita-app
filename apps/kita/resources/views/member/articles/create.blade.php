@extends('layouts.app')

@section('title', '記事投稿')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')
{{-- フラッシュメッセージ --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('articles.store') }}">
    @csrf

    {{-- タイトル --}}
    <div class="mb-3">
        <label for="title">タイトル</label>
        <input
            type="text"
            name="title"
            id="title"
            class="form-control form-control--green"
            value="{{ old('title') }}"
            required
            maxlength="255">
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- タグ --}}
    <div class="mb-3">
        <label for="tags">タグ</label>
        <select
            name="tags[]"
            id="tags"
            class="form-control form-control--green"
            multiple>
            @foreach ($tags as $tag)
            <option
                value="{{ $tag->id }}"
                @if (in_array($tag->id, old('tags', []))) selected @endif
                >
                {{ $tag->name }}
            </option>
            @endforeach
        </select>
        @error('tags')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- 記事内容 --}}
    <div class="mb-3">
        <label for="contents">記事内容</label>
        <textarea
            name="contents"
            id="contents"
            class="form-control form-control--green"
            rows="8"
            required>{{ old('contents') }}</textarea>
        @error('contents')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- 投稿ボタン --}}
    <div class="form-actions">
        <button type="submit" class="btn btn-article-submit">
            投稿する
        </button>
    </div>
</form>

@endsection