@extends('layouts.admin')

@section('title', 'タグ管理 - 新規登録')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<h2 class="mb-4 fs-3">タグ管理 - 新規登録</h2>

{{-- 入力エラー（バリデーション） --}}
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
                <h3 class="card-title">タグ情報の入力</h3>
                <div class="card-tools">
                    <a href="{{ route('article_tags.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left mr-1"></i> 一覧に戻る
                    </a>
                </div>
            </div>

            {{-- Horizontal Form --}}
            <form action="{{ route('article_tags.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="card-body">

                    {{-- タグ名 --}}
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-sm-right">
                            <span class="badge badge-danger mr-1">必須</span> タグ名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="例：Java"
                                required maxlength="255">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
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
                            <a href="{{ route('article_tags.index') }}" class="btn btn-default ml-2">
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