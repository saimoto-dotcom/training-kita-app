@extends('layouts.admin')

@section('title', '管理者管理')

@section('content')
<div class="container py-5 text-center">
    <h2>管理者ダッシュボード（仮ページ）</h2>
    <p>ここに管理画面の内容を表示します。</p>
    <form method="GET" action="{{ route('admin.logout') }}">
        <button type="submit" class="btn btn-outline-secondary">ログアウト</button>
    </form>
</div>
@endsection