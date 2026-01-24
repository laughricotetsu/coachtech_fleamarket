@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
<div class="purchase-wrapper">

    <div class="purchase-container">

        <!-- 左エリア -->
        <div class="purchase-left">

            <!-- 商品情報 -->
            <div class="item-box">
                <div class="item-image">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                </div>

                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <hr>

        <!-- 支払い方法 -->
        <div class="payment-box">
            <p class="label">支払い方法</p>

            @error('payment_method')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <form action="{{ route('purchase.payment.update', ['item' => $item->id]) }}"
                method="POST">
                @csrf

                @php
                    $paymentMethod = session('payment_method', '');
                @endphp

                <select id="payment-select"
                        name="payment_method"
                        onchange="this.form.submit()">

                    <option value="">選択してください</option>

                    <option value="コンビニ払い"
                        {{ $paymentMethod === 'コンビニ払い' ? 'selected' : '' }}>
                        コンビニ払い
                    </option>

                    <option value="クレジットカード"
                        {{ $paymentMethod === 'クレジットカード' ? 'selected' : '' }}>
                        クレジットカード
                    </option>
                </select>
            </form>
        </div>

            <hr>

            <!-- 配送先 -->
            @php
                $shipping = session('purchase_address', [
                    'postal_code'      => $user->postal_code,
                    'shipping_address' => $user->address,
                    'building'         => $user->building,
                ]);
            @endphp

            <div class="address-box">
                <div class="address-header">
                    <p class="label">配送先</p>
                    <a href="{{ route('purchase.address.edit', ['item' => $item->id]) }}" class="change">
                        変更する
                    </a>
                </div>

                @error('postal_code')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <div class="shipping-address">
                    <p>〒 {{ $shipping['postal_code'] }}</p>
                    <p>
                        {{ $shipping['shipping_address'] }}
                        {{ $shipping['building'] }}
                    </p>
                </div>
            </div>

            <hr>

        </div>

        <!-- 右エリア -->
        <div class="purchase-right">

            <div class="summary-box">
                    <div class="summary-row">
                        <span>商品代金</span>
                        <span>¥{{ number_format($item->price) }}</span>
                    </div>

                @php
                    $paymentMethod = session('payment_method', '未選択');
                @endphp

                <div class="summary-row">
                    <span>支払い方法</span>
                    <span>{{ $paymentMethod }}</span>
                </div>
        </div>

            @if ($item->is_sold)
                <p class="sold-text">この商品は売り切れました</p>

            @elseif (auth()->id() === $item->user_id)
                <p class="own-item-text">自分の商品は購入できません</p>

            @else
                <form action="{{ route('purchase.checkout', $item) }}" method="POST">
                    @csrf
                    <!-- セッションから取得した値を hidden で送信 -->
                    <input type="hidden" name="payment_method" value="{{ session('payment_method') }}">
                    <input type="hidden" name="postal_code" value="{{ $shipping['postal_code'] }}">
                    <input type="hidden" name="address" value="{{ $shipping['shipping_address'] }}">
                    <button class="buy-button">購入する</button>
                </form>
            @endif

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentSelect = document.getElementById('payment-select');
    const paymentText = document.getElementById('payment-method-text');

    paymentSelect.addEventListener('change', function () {
        paymentText.textContent = this.value === '' ? '未選択' : this.value;
    });
});
</script>

@endsection
