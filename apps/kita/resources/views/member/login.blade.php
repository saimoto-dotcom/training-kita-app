@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

@if ($errors->has('auth'))
<div class="alert alert-danger">
    {{ $errors->first('auth') }}
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">

                <h4 class="mb-3">Kitaログイン</h4>
                <hr>
                <div class="text-end mb-3">
                    新規会員登録は
                    <a href="/member_registration" class="fw-bold text-decoration-none">
                        こちら
                    </a>
                </div>

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">メールアドレス</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                            maxlength="255"
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
                            class="form-control"
                            required
                            minlength="8"
                            maxlength="255">

                        @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        ログイン
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection