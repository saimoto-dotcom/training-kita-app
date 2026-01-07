@extends('layouts.admin')

@section('title', '管理者管理 - 編集')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fs-3">管理者管理 - 編集</h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
    @endif

    {{-- 入力エラー（バリデーション） --}}
    @if ($errors->any())
    <div class="alert alert-danger mb-3">
        入力内容に不備があります。各項目をご確認ください。
    </div>
    @endif

    <div class="row">
        {{-- 左側：メインフォーム --}}
        <div class="col-md-9">
            <form action="{{ route('admin_users.update', $admin_user->id) }}"
                method="POST"
                id="update-form">
                @csrf
                @method('PUT')

                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        {{-- ID --}}
                        <div class="mb-4">
                            <label class="form-label">ID</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $admin_user->id }}"
                                readonly>
                        </div>

                        {{-- 姓 --}}
                        <div class="mb-4">
                            <label for="last_name"
                                class="form-label label-required">姓</label>
                            <input type="text"
                                name="last_name"
                                id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name', $admin_user->last_name) }}"
                                required
                                maxlength="255">
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
                                value="{{ old('first_name', $admin_user->first_name) }}"
                                required
                                maxlength="255">
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
                                value="{{ old('email', $admin_user->email) }}"
                                required
                                maxlength="255">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- パスワード（表示項目：input不使用） --}}
                        <div class="mb-4">
                            <label class="form-label">パスワード</label>
                            <div class="form-control-plaintext">
                                ********
                            </div>
                        </div>

                        {{-- 更新日時 --}}
                        <div class="mb-4">
                            <label class="form-label">更新日時</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $admin_user->updated_at->format('Y/m/d H:i:s') }}"
                                readonly>
                        </div>

                        {{-- 登録日時 --}}
                        <div class="mb-0">
                            <label class="form-label">登録日時</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $admin_user->created_at->format('Y/m/d H:i:s') }}"
                                readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- 右側：アクションボタンエリア --}}
        <div class="col-md-3">
            <div class="sticky-sidebar">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit"
                            form="update-form"
                            class="btn btn-primary w-100 py-2 mb-3">
                            更新する
                        </button>

                        <form method="POST"
                            action="{{ route('admin_users.destroy', $admin_user->id) }}"
                            onsubmit="return confirm('一度削除すると元に戻せません。\n削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 py-2">
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection