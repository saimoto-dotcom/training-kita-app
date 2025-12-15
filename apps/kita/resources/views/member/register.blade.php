@extends('layouts.app')

@section('title', '会員登録')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    入力内容に不備があります。各項目をご確認ください。
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">

                <h4 class="mb-3">Kita会員登録</h4>
                <hr>

                <form method="POST" action="/member_registration">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ユーザー名</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">メールアドレス</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}">
                        @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">パスワード</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control">
                        @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">パスワード（確認用）</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control">
                        @error('password_confirmation')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        登録する
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection