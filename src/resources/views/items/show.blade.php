@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')
<div class="detail-wrapper">

    {{-- 左：商品画像 --}}
    <div class="detail-left">
        @if ($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}" class="item-image" alt="{{ $item->name }}">
        @else
            <div class="no-image-box">商品画像</div>
        @endif
    </div>

    {{-- 右：商品情報 --}}
    <div class="detail-right">
        <h2 class="item-title">{{ $item->name }}</h2>

        <p class="item-price">¥{{ number_format($item->price) }} <span class="tax">(税込)</span></p>

        <div class="icon-area">
            <span class="icon">♡</span>
            <span class="icon">💬</span>
        </div>

        <a href="{{ route('items.purchase', $item->id) }}" class="buy-btn">購入手続きへ</a>

        {{-- 商品説明 --}}
        <div class="section">
            <h3 class="section-title">商品説明</h3>
            <p class="item-description">{{ $item->description }}</p>
        </div>

        {{-- 商品の情報 --}}
        <div class="section">
            <h3 class="section-title">商品の情報</h3>

            <div class="info-row">
                <span class="info-label">カテゴリー</span>
                <span class="info-value">例: メンズ</span>
            </div>

            <div class="info-row">
                <span class="info-label">商品の状態</span>
                <span class="info-value">{{ $item->condition }}</span>
            </div>
        </div>

        {{-- コメント一覧 --}}
        <div class="section">
            <h3 class="section-title">コメント (1)</h3>

            <div class="comment-box">
                <div class="comment-user">● admin</div>
                <div class="comment-text">こちらにコメントが入ります。</div>
            </div>
        </div>

        {{-- コメントフォーム --}}
        <div class="section">
            <h3 class="section-title">商品のコメント</h3>

            <textarea class="comment-textarea" placeholder="コメントを入力してください"></textarea>
            <button class="comment-btn">コメントを投稿する</button>
        </div>

    </div>

</div>
@endsection
