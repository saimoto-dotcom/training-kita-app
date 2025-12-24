@extends('layouts.app')

@section('title', '記事編集')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')

{{-- フラッシュメッセージ --}}
@if (session('success'))
<div class="alert alert-success">
    <span class="fw-bold fs-5">Success!</span><br>
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

{{-- 記事編集フォーム --}}
<form method="POST" action="{{ route('articles.update', $article) }}">
    @include('member.articles._form', [
    'article' => $article,
    'tags' => $tags,
    'update' => true
    ])
</form>

@endsection