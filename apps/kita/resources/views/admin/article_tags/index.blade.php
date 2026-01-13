@extends('layouts.admin')

@section('title', 'タグ管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

{{-- ページタイトル --}}
<h2 class="mb-4">タグ管理</h2>

{{-- フラッシュメッセージ --}}
@if (session('success'))
<div class="alert alert-success shadow-sm mb-3">
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {{ session('success') }}
</div>
@endif

{{-- 検索フォーム --}}
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search mr-1"></i> 検索条件</h3>
    </div>
    <form method="GET" action="{{ route('article_tags.index') }}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">タグ名</label>
                        <input type="text" name="name" id="name"
                            class="form-control" value="{{ request('name') }}"
                            placeholder="例：Java" maxlength="255">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('article_tags.index') }}" class="btn btn-default mr-2">クリア</a>
                <button type="submit" class="btn btn-primary px-4">検索</button>
            </div>
        </div>
    </form>
</div>

{{-- 0件メッセージ --}}
@if ($tags->isEmpty() && request('name'))
<div class="alert alert-warning">
    <i class="icon fas fa-exclamation-triangle"></i> 該当データがありません
</div>
@endif

{{-- ページネーション（上部） --}}
@if($tags->hasPages())
<div class="mb-3">
    {{ $tags->links('pagination::bootstrap-4') }}
</div>
@endif

{{-- 一覧表示 --}}
@if($tags->isNotEmpty())
<div class="card shadow-sm">
    <div class="card-header border-transparent">
        <h3 class="card-title"><i class="fas fa-tag mr-1"></i> タグ一覧</h3>
        <div class="card-tools">
            <a href="{{ route('article_tags.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> 新規登録
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped m-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 80px">ID</th>
                        <th>タグ名</th>
                        <th>登録日時</th>
                        <th class="text-center" style="width: 120px">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                    <tr>
                        <td class="text-center">{{ $tag->id }}</td>
                        <td class="font-weight-bold">{{ $tag->name }}</td>
                        <td>{{ $tag->created_at->format('Y/m/d H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('article_tags.edit', $tag->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection