@extends('layouts.admin')

@section('title', '管理者管理 - 新規登録')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<h2 class="mb-4 fs-3">管理者管理 - 新規登録</h2>

{{-- 入力エラー（バリデーション） --}}
@if ($errors->any())
<div class="alert alert-danger shadow-sm">
    <h5><i class="icon fas fa-ban"></i> Error!</h5>
    入力内容に不備があります。
</div>
@endif

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title">管理者情報の入力</h3>
                <div class="card-tools">
                    <a href="{{ route('admin_users.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left mr-1"></i> 一覧に戻る
                    </a>
                </div>
            </div>

            {{-- Horizontal Form --}}
            <form action="{{ route('admin_users.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="card-body">

                    {{-- 姓 --}}
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> 姓
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="last_name" id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') }}" placeholder="例：佐藤" required>
                            @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- 名 --}}
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> 名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="first_name" id="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') }}" placeholder="例：京助" required>
                            @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- メールアドレス --}}
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> メールアドレス
                        </label>
                        <div class="col-sm-8">
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="example@test.com" required>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- パスワード --}}
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> パスワード
                        </label>
                        <div class="col-sm-8">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="8文字以上の半角英数字" required>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- パスワード（確認） --}}
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> パスワード(確認)
                        </label>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="もう一度入力してください" required>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save mr-1"></i> 登録する
                            </button>
                            <a href="{{ route('admin_users.index') }}" class="btn btn-default ml-2">
                                キャンセル
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection