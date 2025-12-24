@csrf
@isset($update)
@method('PUT')
@endisset

{{-- タイトル --}}
<div class="mb-3">
    <label for="title">タイトル</label>
    <input
        type="text"
        name="title"
        id="title"
        class="form-control form-control--green"
        value="{{ old('title', $article->title ?? '') }}"
        required
        maxlength="255">
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- タグ --}}
<div class="mb-3">
    <label for="tags">タグ</label>
    <select
        name="tags[]"
        id="tags"
        class="form-control form-control--green"
        multiple>

        @php
        $selectedTags = old(
        'tags',
        isset($article)
        ? $article->tags->pluck('id')->toArray()
        : []
        );
        @endphp

        @foreach ($tags as $tag)
        <option
            value="{{ $tag->id }}"
            @selected(in_array($tag->id, $selectedTags))
            >
            {{ $tag->name }}
        </option>
        @endforeach
    </select>

    @error('tags')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- 記事内容 --}}
<div class="mb-3">
    <label for="contents">記事内容</label>
    <textarea
        name="contents"
        id="contents"
        class="form-control form-control--green"
        rows="8"
        required>{{ old('contents', $article->contents ?? '') }}</textarea>

    @error('contents')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- 送信ボタン --}}
<div class="form-actions">
    <button type="submit" class="btn btn-article-submit">
        {{ isset($update) ? '保存する' : '投稿する' }}
    </button>
</div>