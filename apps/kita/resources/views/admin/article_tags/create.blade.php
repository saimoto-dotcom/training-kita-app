@extends('layouts.admin')

@section('title', 'タグ管理 - 新規登録')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fs-3">タグ管理 - 新規登録</h2>

    {{-- 入力エラー（バリデーション） --}}
    @if ($errors->any())
    <div class="alert alert-danger mb-3">
        入力内容に不備があります。各項目をご確認ください。
    </div>
    @endif

    <form action="{{ route('article_tags.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- 左側：メイン入力フォーム --}}
            <div class="col-md-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">

                        {{-- タグ名 --}}
                        <div class="mb-2">
                            <label for="name"
                                class="form-label label-required">タグ名</label>
                            <input type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                required
                                maxlength="255">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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