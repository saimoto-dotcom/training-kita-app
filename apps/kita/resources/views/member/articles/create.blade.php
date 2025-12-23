@extends('layouts.app')

@section('title', '記事投稿')

@section('content')
<h1>記事投稿</h1>

<p>{{ Auth::check() ? 'login' : 'guest' }}</p>

<p>※ 表示内容は仮</p>
@endsection