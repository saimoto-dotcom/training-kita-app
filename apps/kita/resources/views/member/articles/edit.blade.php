@extends('layouts.app')

@section('title', '記事編集')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')
<h1>記事編集</h1>

@if (session('success'))
<div class="alert alert-success">
    <span class="fw-bold fs-5">Success!</span><br>
    記事投稿が完了しました
</div>
@endif

<p>{{ Auth::check() ? 'login' : 'guest' }}</p>

<p>※ 表示内容は仮</p>

@endsection