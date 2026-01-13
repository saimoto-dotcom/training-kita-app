@extends('layouts.admin-guest')

@section('title', '管理者ログイン')

@section('content')
<p class="login-box-msg">ログイン情報を入力してください</p>

{{-- エラー表示 --}}
@if($errors->any())
<div class="alert alert-danger p-2 mb-3">
    @foreach($errors->all() as $error)
    <div class="small">{{ $error }}</div>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    {{-- メールアドレス --}}
    <div class="input-group mb-3">
        <input type="email" name="email" value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="メールアドレス" required autofocus>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
    </div>

    {{-- パスワード --}}
    <div class="input-group mb-3">
        <input type="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="パスワード" required>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
                ログイン
            </button>
        </div>
    </div>
</form>
@endsection