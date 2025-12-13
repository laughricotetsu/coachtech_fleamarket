@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')
<div class="tab-menu">
    <a href="{{ route('items.index') }}" class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="{{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

<div class="products-container">
    @foreach ($items as $item)
        <a href="{{ route('items.show', $item->id) }}" class="product-card">
            <div class="product-img">
                @if ($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">

                @else
                    <div class="no-img">商品画像</div>
                @endif
            </div>
            <p class="product-name">{{ $item->name }}</p>
        </a>
    @endforeach
</div>
@endsection
