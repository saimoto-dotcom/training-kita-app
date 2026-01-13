@extends('layouts.admin')

@section('title', 'タグ管理 - 更新')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<h2 class="mb-4 fs-3">タグ管理 - 更新</h2>

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
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title">タグ情報の編集</h3>
                <div class="card-tools">
                    <a href="{{ route('article_tags.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left mr-1"></i> 一覧に戻る
                    </a>
                </div>
            </div>

            {{-- Horizontal Form --}}
            <form action="{{ route('article_tags.update', $articleTag->id) }}" method="POST" id="update-form" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- ID (Readonly) --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-sm-right">ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext font-weight-bold"
                                value="{{ $articleTag->id }}" readonly>
                        </div>
                    </div>

                    {{-- タグ名 --}}
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> タグ名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $articleTag->name) }}" required maxlength="255">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- 各種日時 --}}
                    <div class="form-group row text-muted">
                        <label class="col-sm-3 col-form-label text-sm-right">登録日時</label>
                        <div class="col-sm-8 col-form-label">
                            {{ $articleTag->created_at->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                    <div class="form-group row text-muted">
                        <label class="col-sm-3 col-form-label text-sm-right">最終更新</label>
                        <div class="col-sm-8 col-form-label">
                            {{ $articleTag->updated_at->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                </div>
            </form>

            {{-- アクションボタン --}}
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-3">
                        {{-- 削除フォーム --}}
                        <form method="POST" action="{{ route('article_tags.destroy', $articleTag->id) }}"
                            onsubmit="return confirm('一度削除すると元に戻せません。\n削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt mr-1"></i> 削除
                            </button>
                        </form>
                    </div>
                    <div class="col-sm-8 text-right">
                        <a href="{{ route('article_tags.index') }}" class="btn btn-default mr-2">
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