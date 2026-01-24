@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')

@php
    $query = request()->query();
@endphp

<div class="tab-menu">
    <a href="{{ route('items.index', array_merge($query, ['tab' => null])) }}"
    class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('items.index', array_merge($query, ['tab' => 'mylist'])) }}"
    class="{{ request('tab') === 'mylist' ? 'active' : '' }}">
        マイリスト
    </a>
</div>


<div class="products-container">
    @foreach ($items as $item)
        <a href="{{ route('items.show', $item->id) }}" class="product-card">
            <div class="product-img">
                @if ($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">

                @else
                    <div class="no-img">商品画像</div>
                @endif
            </div>
            <p class="product-name">{{ $item->name }}</p>

            <div class="item-card">
                @if ($item->is_sold)
                    <span class="sold-label">Sold</span>
                @endif
            </div>

        </a>
    @endforeach
</div>
@endsection
