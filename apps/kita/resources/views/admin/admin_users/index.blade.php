@extends('layouts.admin')

@section('title', '管理者管理')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">

    {{-- ページタイトル --}}
    <h2 class="mb-4">管理者管理</h2>

    {{-- 検索フォーム --}}
    <div class="card mb-4">
        <div class="card-body">
            {{ Form::open(['route' => 'admin_users.index', 'method' => 'get']) }}
            <div class="row g-3">
                <div class="col-md-4">
                    {{ Form::label('last_name', '姓', ['class' => 'form-label']) }}
                    {{ Form::text('last_name', request('last_name'), [
                            'class' => 'form-control',
                            'maxlength' => 255
                        ]) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('first_name', '名', ['class' => 'form-label']) }}
                    {{ Form::text('first_name', request('first_name'), [
                            'class' => 'form-control',
                            'maxlength' => 255
                        ]) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('email', 'メールアドレス', ['class' => 'form-label']) }}
                    {{ Form::text('email', request('email'), [
                            'class' => 'form-control',
                            'maxlength' => 255
                        ]) }}
                </div>
            </div>

            <div class="text-center mt-4">
                {{ Form::submit('検索', ['class' => 'btn btn-primary px-5']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

    {{-- 0件メッセージ（検索時のみ） --}}
    @if (
    $adminUsers->isEmpty() &&
    ($lastName || $firstName || $email)
    )
    <div class="alert alert-danger">
        該当データがありません
    </div>
    @endif

    {{-- ページネーション（← 正しい場所） --}}
    @if($adminUsers->hasPages())
    <div class="mb-3">
        {{ $adminUsers->links('pagination::bootstrap-4') }}
    </div>
    @endif

    {{-- 一覧表示 --}}
    @if($adminUsers->isNotEmpty())
    <div class="card">
        <div class="card-body">

            {{-- 新規登録ボタン --}}
            <div class="mb-3">
                <a href="{{ route('admin_users.create') }}" class="btn btn-primary">
                    新規登録
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th class="text-end">更新日時</th>
                            <th class="text-end">登録日時</th>
                            <th class="text-center">レコード操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($adminUsers as $adminUser)
                        <tr>
                            <td class="text-center">{{ $adminUser->id }}</td>
                            <td>
                                {{ $adminUser->last_name }}
                                {{ $adminUser->first_name }}
                            </td>
                            <td>{{ $adminUser->email }}</td>
                            <td class="text-end">
                                {{ $adminUser->updated_at->format('Y/m/d H:i') }}
                            </td>
                            <td class="text-end">
                                {{ $adminUser->created_at->format('Y/m/d H:i') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin_users.edit', $adminUser->id) }}"
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