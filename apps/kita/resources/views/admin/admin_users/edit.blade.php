@extends('layouts.admin')

@section('title', '管理者管理 - 編集')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<h2 class="mb-4 fs-3">管理者管理 - 編集</h2>

{{-- フラッシュメッセージ --}}
@if (session('success'))
<div class="alert alert-success shadow-sm mb-3">
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {{ session('success') }}
</div>
@endif

{{-- 入力エラー --}}
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
                <h3 class="card-title">管理者情報の編集</h3>
                <div class="card-tools">
                    <a href="{{ route('admin_users.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left mr-1"></i> 一覧に戻る
                    </a>
                </div>
            </div>

            {{-- Horizontal Form --}}
            <form action="{{ route('admin_users.update', $admin_user->id) }}" method="POST" id="update-form" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- ID (Readonly) --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-sm-right">ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext font-weight-bold"
                                value="{{ $admin_user->id }}" readonly>
                        </div>
                    </div>

                    {{-- 姓 --}}
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> 姓
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="last_name" id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name', $admin_user->last_name) }}" required>
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
                                value="{{ old('first_name', $admin_user->first_name) }}" required>
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
                                value="{{ old('email', $admin_user->email) }}" required>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- 各種日時 (Readonly) --}}
                    <div class="form-group row text-muted">
                        <label class="col-sm-3 col-form-label text-sm-right">登録日時</label>
                        <div class="col-sm-8 col-form-label">
                            {{ $admin_user->created_at->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                    <div class="form-group row text-muted">
                        <label class="col-sm-3 col-form-label text-sm-right">最終更新</label>
                        <div class="col-sm-8 col-form-label">
                            {{ $admin_user->updated_at->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                </div>
            </form>

            {{-- アクションボタンエリア --}}
            <div class="card-footer">
                <div class="row">
                    {{-- 左側：削除ボタン --}}
                    <div class="col-sm-3">
                        <form method="POST" action="{{ route('admin_users.destroy', $admin_user->id) }}"
                            onsubmit="return confirm('一度削除すると元に戻せません。\n削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt mr-1"></i> 削除
                            </button>
                        </form>
                    </div>

                    {{-- 右側：更新・キャンセルボタン --}}
                    <div class="col-sm-8 text-right">
                        <a href="{{ route('admin_users.index') }}" class="btn btn-default mr-2">
                            キャンセル
                        </a>
                        <button type="submit" form="update-form" class="btn btn-primary px-5">
                            <i class="fas fa-save mr-1"></i> 更新する
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection