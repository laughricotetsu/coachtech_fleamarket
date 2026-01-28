@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')

{{-- 上：画像＋商品情報 --}}
<div class="detail-wrapper">

    {{-- 左：商品画像 --}}
    <div class="detail-left">

        @if ($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}" class="item-image">
        @else
            <div class="no-image-box">商品画像</div>
        @endif
    </div>

    {{-- 右：商品情報 --}}
    <div class="detail-right">

        <h2 class="item-title">{{ $item->name }}</h2>

        @if($item->brand)
            <p class="item-brand">{{ $item->brand }}</p>
        @endif

        <p class="item-price">
            ¥{{ number_format($item->price) }}
            <span class="tax">(税込)</span>
        </p>

        {{-- ❤️ 💬 --}}
        <div class="reaction-area">

            <div class="reaction" id="like-area" data-item-id="{{ $item->id }}">
                <button id="like-btn" type="button">
                    <img
                        id="like-icon"
                        src="{{ $item->is_liked
                            ? asset('item/ハートロゴ_ピンク.png')
                            : asset('item/ハートロゴ_デフォルト.png') }}"
                        class="reaction-icon">
                </button>
                <span id="like-count">{{ $item->likes_count }}</span>
            </div>

            <div class="reaction">
                <img src="{{ asset('item/ふきだしロゴ.png') }}" class="reaction-icon">
                <span id="comment-count">{{ $item->comments_count }}</span>
            </div>

        </div>

        {{-- 購入 --}}
        <a href="{{ route('purchase', ['item' => $item->id]) }}" class="purchase-btn">
            購入手続きへ
        </a>

        {{-- 商品説明 --}}
        <div class="section">
            <h3 class="section-title">商品説明</h3>
            <p>{{ $item->description }}</p>

            @if($item->color)
                <p class="item-color">カラー：{{ $item->color }}</p>
            @endif
        </div>

        {{-- 商品情報 --}}
        <div class="section">
            <h3 class="section-title">商品の情報</h3>

            <div class="info-row">
            @if ($item->categories->isNotEmpty())
                @foreach ($item->categories as $category)
                    <span class="category-tag">{{ $category->name }}</span>
                @endforeach
            @else
                <span>未分類</span>
            @endif

            </div>

            <div class="info-row">
                <span class="info-label">商品の状態</span>
                <span class="info-value">{{ $item->condition }}</span>
            </div>
        </div>

        {{-- コメント一覧 --}}
        <div class="section">
            <h3 class="section-title">
                コメント (<span id="comment-count">{{ $item->comments_count }}</span>)
            </h3>

            <div id="comment-list">
                @foreach($item->comments as $comment)
                    <div class="comment-box">
                        <div class="comment-user">● {{ $comment->user->name }}</div>
                        <div class="comment-text">{{ $comment->body }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- 下：コメント投稿 --}}
<div class="comment-wrapper">
    <h3 class="section-title">商品のコメント</h3>

    <form action="{{ route('items.comment', $item->id) }}" method="post">
        @csrf

            {{-- エラーメッセージ --}}
        @error('comment')
            <p class="error">{{ $message }}</p>
        @enderror


        <textarea
            name="comment"
            placeholder="コメントを入力してください"
        >{{ old('comment') }}</textarea>

            <button
                type="submit">
                コメントを投稿する
            </button>
        <input type="hidden" name="id" value="{{ $item->id }}">
    </form>
</div>



{{-- Ajax --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* =========================
    いいね Ajax
    ========================= */
    const likeArea = document.getElementById('like-area');

    if (likeArea) {
        likeArea.addEventListener('click', () => {
            const itemId = likeArea.dataset.itemId;

            fetch(`/item/${itemId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('like-count').textContent = data.likes_count;
                document.getElementById('like-icon').src = data.is_liked
                    ? "{{ asset('item/ハートロゴ_ピンク.png') }}"
                    : "{{ asset('item/ハートロゴ_デフォルト.png') }}";
            });
        });
    }

//     // * =========================
//     //  コメント投稿 Ajax
//     //  ========================= */
//         const form = document.getElementById('comment-form');
//         const submitBtn = document.getElementById('comment-submit');
//         const textarea = document.getElementById('comment-body');
//         const errorEl = document.getElementById('comment-error');

//         // formのsubmitを完全に止める（超重要）
//         form.addEventListener('submit', e => {
//                         e.preventDefault();
//      });

//      submitBtn.addEventListener('click', () => {

//          const body = textarea.value.trim();
//          const url = submitBtn.dataset.url;

//          errorEl.textContent = '';

//          // フロント側簡易チェック
//          if (body === '') {
//              errorEl.textContent = 'コメントを入力してください';
//              return;
//          }

//          fetch(url, {
//              method: 'POST',
//              headers: {
//                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//                  'Content-Type': 'application/json',
//                  'Accept': 'application/json',
//              },
//              body: JSON.stringify({ comment: body })
//          })
//          .then(res => {
//              if (!res.ok) {
//                  return res.json().then(err => {
//                      throw err;
//                  });
//                           return res.json();
//          })

//          .then(data => {
//             // コメント一覧に追加
//              const list = document.getElementById('comment-list');
//              if (list) {
//                  const div = document.createElement('div');
//                  div.classList.add('comment-box');
//                  div.innerHTML = `
//                      <div class="comment-user">● ${data.user_name}</div>
//                      <div class="comment-text">${data.body}</div>
//                  `;
//                  list.prepend(div);
//              }

//              // カウント更新
//              document.querySelectorAll('#comment-count').forEach(el => {
//                  el.textContent = data.comments_count;
//              });

//              textarea.value = '';
//         })
//          .catch(err => {
//              if (err.errors && err.errors.comment) {
//                  errorEl.textContent = err.errors.comment[0];
//              } else {
//                  errorEl.textContent = 'コメントの投稿に失敗しました';
//              }
//          });
//      });
});
</script>

@endsection
