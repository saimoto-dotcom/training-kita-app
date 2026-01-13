@extends('layouts.admin')

@section('title', '管理者管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
{{-- ページタイトル --}}
<h2 class="mb-4">管理者管理</h2>

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
    <form method="GET" action="{{ route('admin_users.index') }}">
        <div class="card-body">
            <div class="row">
                {{-- 姓 --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="last_name">姓</label>
                        <input type="text" name="last_name" id="last_name"
                            class="form-control" value="{{ request('last_name') }}"
                            placeholder="例：佐藤">
                    </div>
                </div>
                {{-- 名 --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name">名</label>
                        <input type="text" name="first_name" id="first_name"
                            class="form-control" value="{{ request('first_name') }}"
                            placeholder="例：京助">
                    </div>
                </div>
                {{-- メールアドレス --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email" id="email"
                            class="form-control" value="{{ request('email') }}"
                            placeholder="example@test.com">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('admin_users.index') }}" class="btn btn-default mr-2">クリア</a>
                <button type="submit" class="btn btn-primary px-4">検索</button>
            </div>
        </div>
    </form>
</div>

{{-- 0件メッセージ --}}
@if($adminUsers->isEmpty() && (request('last_name') || request('first_name') || request('email')))
<div class="alert alert-warning">
    <i class="icon fas fa-exclamation-triangle"></i> 該当データがありません
</div>
@endif

{{-- ページネーション --}}
@if($adminUsers->hasPages())
<div class="mb-3">
    {{ $adminUsers->links('pagination::bootstrap-4') }}
</div>
@endif

{{-- 一覧表示 --}}
@if($adminUsers->isNotEmpty())
<div class="card shadow-sm">
    <div class="card-header border-transparent">
        <h3 class="card-title"><i class="fas fa-user-shield mr-1"></i> 管理者一覧</h3>
        <div class="card-tools">
            <a href="{{ route('admin_users.create') }}" class="btn btn-sm btn-primary">
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
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>更新日時</th>
                        <th>登録日時</th>
                        <th class="text-center" style="width: 120px">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adminUsers as $adminUser)
                    <tr>
                        <td class="text-center">{{ $adminUser->id }}</td>
                        <td class="font-weight-bold">
                            {{ $adminUser->last_name }} {{ $adminUser->first_name }}
                        </td>
                        <td>{{ $adminUser->email }}</td>
                        <td>{{ $adminUser->updated_at->format('Y/m/d H:i') }}</td>
                        <td>{{ $adminUser->created_at->format('Y/m/d H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin_users.edit', $adminUser->id) }}"
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