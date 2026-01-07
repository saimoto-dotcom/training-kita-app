@extends('layouts.admin')

@section('title', '管理者管理 - 新規登録')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fs-3">管理者管理 - 新規登録</h2>

    {{-- 入力エラー（バリデーション） --}}
    @if ($errors->any())
    <div class="alert alert-danger mb-3">
        入力内容に不備があります。各項目をご確認ください。
    </div>
    @endif

    <form action="{{ route('admin_users.store') }}"
        method="POST">
        @csrf

        <div class="row">
            {{-- 左側：メイン入力フォーム --}}
            <div class="col-md-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">

                        {{-- 姓 --}}
                        <div class="mb-4">
                            <label for="last_name"
                                class="form-label label-required">姓</label>
                            <input type="text"
                                name="last_name"
                                id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') }}"
                                required>
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 名 --}}
                        <div class="mb-4">
                            <label for="first_name"
                                class="form-label label-required">名</label>
                            <input type="text"
                                name="first_name"
                                id="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') }}"
                                required>
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- メールアドレス --}}
                        <div class="mb-4">
                            <label for="email"
                                class="form-label label-required">メールアドレス</label>
                            <input type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- パスワード --}}
                        <div class="mb-4">
                            <label for="password"
                                class="form-label label-required">パスワード</label>
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                                minlength="8">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- パスワード（確認） --}}
                        <div class="mb-2">
                            <label for="password_confirmation"
                                class="form-label label-required">
                                パスワード（確認）
                            </label>
                            <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                required
                                minlength="8">
                        </div>

                    </div>
                </div>
            </div>

            {{-- 右側：追従ボタンエリア --}}
            <div class="col-md-3">
                <div class="sticky-sidebar">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <button type="submit"
                                class="btn btn-primary w-100 py-2">
                                登録する
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection