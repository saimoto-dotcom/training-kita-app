@extends('layouts.admin')

@section('title', 'タグ管理 - 更新')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fs-3">タグ管理 - 更新</h2>

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
            <form action="{{ route('article_tags.update', $articleTag->id) }}"
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
                                class="form-control bg-light"
                                value="{{ $articleTag->id }}"
                                readonly>
                        </div>

                        {{-- タグ名 --}}
                        <div class="mb-4">
                            <label for="name"
                                class="form-label label-required">タグ名</label>
                            <input type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $articleTag->name) }}"
                                required
                                maxlength="255">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 更新日時 --}}
                        <div class="mb-4">
                            <label class="form-label">更新日時</label>
                            <input type="text"
                                class="form-control bg-light"
                                value="{{ $articleTag->updated_at->format('Y/m/d H:i:s') }}"
                                readonly>
                        </div>

                        {{-- 登録日時 --}}
                        <div class="mb-0">
                            <label class="form-label">登録日時</label>
                            <input type="text"
                                class="form-control bg-light"
                                value="{{ $articleTag->created_at->format('Y/m/d H:i:s') }}"
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
                            action="{{ route('article_tags.destroy', $articleTag->id) }}"
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