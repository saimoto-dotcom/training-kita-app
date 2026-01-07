@extends('layouts.admin')

@section('title', '会員管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- ページタイトル --}}
    <h2 class="mb-4">会員管理</h2>

    {{-- 検索フォーム --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row g-3">
                    {{-- ユーザー名 --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label">ユーザー名</label>
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ request('name') }}"
                            maxlength="255">
                    </div>

                    {{-- メールアドレス --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="text"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ request('email') }}"
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

    {{-- 0件メッセージ（検索時のみ） --}}
    @if ($members->isEmpty() && (request('name') || request('email')))
    <div class="alert alert-danger">
        該当データがありません
    </div>
    @endif

    {{-- ページネーション --}}
    @if($members->hasPages())
    <div class="mb-3">
        {{ $members->links('pagination::bootstrap-4') }}
    </div>
    @endif

    {{-- 一覧表示 --}}
    @if($members->isNotEmpty())
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>ユーザー名</th>
                            <th>メールアドレス</th>
                            <th class="text-end">登録日時</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td class="text-center">
                                {{ $member->id }}
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td class="text-end">
                                {{ $member->created_at->format('Y/m/d H:i') }}
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