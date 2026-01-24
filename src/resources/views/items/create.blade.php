@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('content')
<div class="item-create">
    <h2 class="page-title">商品の出品</h2>


    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="item-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label class="section-label">商品画像</label>
            <div class="image-upload">
                <input type="file" name="image">

                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 商品の詳細 --}}
        <div class="form-section">
            <p class="section-title">商品の詳細</p>

            {{-- カテゴリ --}}
            <label class="form-label">カテゴリー</label>
            <div class="category-list">
                @foreach ($categories as $category)
                    <label class="category-item">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                    <span>{{ $category->name }}</span>
                    </label>
                @endforeach

                @error('categories')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            </div>

            {{-- 商品の状態 --}}
            <label class="form-label">商品の状態</label>
            <select name="condition" class="select-box">
                <option value="">選択してください</option>
                <option value="良好" {{ old('condition') === '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>

            @error('condition')
                <p class="error-message">{{ $message }}</p>
            @enderror

        </div>

        {{-- 商品名・説明 --}}
        <div class="form-section">
            <label class="form-label">商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <p class="error-message">{{ $message }}</p> @enderror


            <label class="form-label">ブランド</label>
            <input type="text" name="brand" class="input-box">

            <label class="form-label">商品の説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description') <p class="error-message">{{ $message }}</p> @enderror

        </div>

        {{-- 販売価格 --}}
        <div class="form-section">
            <label class="form-label">販売価格</label>
            <div class="price-box">
                <span class="yen">¥</span>
                <input type="number" name="price" value="{{ old('price') }}">
                @error('price') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-btn">出品する</button>
    </form>
</div>
@endsection
