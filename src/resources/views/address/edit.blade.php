@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endpush

@section('content')
<div class="address-wrapper">

    <h2 class="address-title">住所の変更</h2>

    <form action="{{ route('purchase.address.update', ['item' => $item->id]) }}" method="POST">
        @csrf

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>

            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}"
            >
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="shipping_address">住所</label>

                @error('shipping_address')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            <input
                type="text"
                id="address"
                name="shipping_address"
                value="{{ old('shipping_address', auth()->user()->address ?? '') }}"
            >
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input
                type="text"
                id="building"
                name="building"
                value="{{ old('building', auth()->user()->building ?? '') }}"
            >

            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="update-btn">
            更新する
        </button>
    </form>

</div>
@endsection
