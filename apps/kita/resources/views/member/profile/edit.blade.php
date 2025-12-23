@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<h1>プロフィール編集</h1>

<p>{{ Auth::check() ? 'login' : 'guest' }}</p>

<p>※ 表示内容は仮</p>
@endsection