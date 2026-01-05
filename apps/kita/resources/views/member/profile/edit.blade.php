@extends('layouts.app')

@section('title', 'プロフィール編集')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endpush

@section('content')
<div class="container mt-4">

    {{-- フラッシュメッセージ --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->has('password')) <div class="alert alert-danger">パスワードにエラーがあります</div> @endif

    <div class="card p-4">
        {{-- タイトル --}}
        <h2 class="profile-title">プロフィール編集</h2>
        <hr class="profile-hr">

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ユーザー名 --}}
            <div class="mb-4">
                <label for="name" class="form-label">ユーザー名</label>
                <input type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name', $member->name) }}"
                    required
                    maxlength="255">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="mb-4">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email', $member->email) }}"
                    required
                    maxlength="255">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード（表示のみ） --}}
            <div class="mb-4">
                <label class="form-label">パスワード</label>
                <div class="mt-1 d-flex align-items-center">
                    <span class="bg-light px-2 py-1 rounded me-3">*****</span>
                    <button type="button" class="btn btn-article-submit btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                        パスワードを変更する
                    </button>
                </div>
            </div>

            {{-- 更新ボタン --}}
            <div class="text-end">
                <button type="submit" class="btn btn-article-submit">
                    更新する
                </button>
            </div>
        </form>
    </div>

    {{-- モーダル本体 --}}
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">パスワード変更</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">新しいパスワード</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="255">
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">新しいパスワード（確認）</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-article-submit">
                            更新する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection