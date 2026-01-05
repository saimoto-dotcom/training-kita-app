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
    @include('member.articles._form', ['tags' => $tags])
</form>

@endsection