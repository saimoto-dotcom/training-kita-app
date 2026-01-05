@extends('layouts.admin')

@section('title', '管理者ログイン')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="admin-login-page">

    {{-- タイトル（カード外） --}}
    <div class="admin-login-title">
        <h1>Kita</h1>
        <span>Administrator console</span>
    </div>

    {{-- カードコンテナ --}}
    <div class="admin-login-card">

        {{-- エラー表示 --}}
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        {{-- フォーム --}}
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus>
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    required>
            </div>

            {{-- ログインボタン --}}
            <div class="admin-login-btn">
                <button type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection