@extends('layouts.admin')

@section('title', '会員管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
{{-- ページタイトル --}}
<h2 class="mb-4">会員管理</h2>

{{-- 検索フォーム --}}
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search mr-1"></i> 検索条件</h3>
    </div>
    <form method="GET" action="{{ route('users.index') }}">
        <div class="card-body">
            <div class="row">
                {{-- ユーザー名 --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">ユーザー名</label>
                        <input type="text" name="name" id="name"
                            class="form-control" value="{{ request('name') }}"
                            placeholder="例：中村 直樹" maxlength="255">
                    </div>
                </div>

                {{-- メールアドレス --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email" id="email"
                            class="form-control" value="{{ request('email') }}"
                            placeholder="example@test.com" maxlength="255">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('users.index') }}" class="btn btn-default mr-2">クリア</a>
                <button type="submit" class="btn btn-primary px-4">検索</button>
            </div>
        </div>
    </form>
</div>

{{-- 0件メッセージ --}}
@if ($members->isEmpty() && (request('name') || request('email')))
<div class="alert alert-warning">
    <i class="icon fas fa-exclamation-triangle"></i> 該当データがありません
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
<div class="card shadow-sm">
    <div class="card-header border-transparent">
        <h3 class="card-title"><i class="fas fa-users mr-1"></i> 会員一覧</h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped m-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 80px">ID</th>
                        <th>ユーザー名</th>
                        <th>メールアドレス</th>
                        <th>登録日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                    <tr>
                        <td class="text-center">{{ $member->id }}</td>
                        <td class="font-weight-bold">{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->created_at->format('Y/m/d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection