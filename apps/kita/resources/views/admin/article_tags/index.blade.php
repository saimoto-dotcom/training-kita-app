@extends('layouts.admin')

@section('title', 'タグ管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">

    {{-- ページタイトル --}}
    <h2 class="mb-4">タグ管理</h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
    @endif

    {{-- 検索フォーム --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('article_tags.index') }}">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="name" class="form-label">タグ名</label>
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ request('name') }}"
                            maxlength="255">
                    </div>
                </div>

                {{-- 検索ボタン --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        検索
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 0件メッセージ --}}
    @if ($tags->isEmpty() && request('name'))
    <div class="alert alert-danger">
        該当データがありません
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
    <div class="card">
        <div class="card-body">

            {{-- 新規登録ボタン --}}
            <div class="mb-3">
                <a href="{{ route('article_tags.create') }}"
                    class="btn btn-primary">
                    新規登録
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="text-center table-col-id">ID</th>
                            <th>タグ名</th>
                            <th class="text-end table-col-datetime">登録日時</th>
                            <th class="text-center table-col-action">
                                レコード操作
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                        <tr>
                            <td class="text-center">{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td class="text-end">
                                {{ $tag->created_at->format('Y/m/d H:i') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('article_tags.edit', $tag->id) }}"
                                    class="btn btn-sm btn-primary">
                                    編集
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

</div>
@endsection