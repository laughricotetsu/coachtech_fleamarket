@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/mypage_index.css') }}">
@endpush

@section('content')

<div class="mypage-wrapper">

    {{-- プロフィール --}}
    <div class="profile-area">
        <div class="profile-left">
            <div class="avatar"></div>
            <h2 class="username">{{ $user->name }}</h2>
        </div>

        <a href="{{ route('profile.edit') }}" class="profile-edit-btn">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    <div class="tab-area">
    <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
       class="tab {{ request('page', 'sell') === 'sell' ? 'active' : '' }}">
        出品した商品
    </a>

    <a href="{{ route('mypage.index', ['page' => 'buy']) }}"
       class="tab {{ request('page') === 'buy' ? 'active' : '' }}">
        購入した商品
    </a>
</div>


{{-- 出品 --}}
@if(request('page', 'sell') === 'sell')
<div class="item-list">
    @foreach($sellItems as $item)
        <div class="item-card">
            <img src="{{ asset('storage/'.$item->image_path) }}">
            <p>{{ $item->name }}</p>
        </div>
    @endforeach
</div>
@endif

{{-- 購入 --}}
@if(request('page') === 'buy')
<div class="item-list">
    @foreach($buyItems as $purchase)
        <div class="item-card">
            <img src="{{ asset('storage/'.$purchase->item->image_path) }}">
            <p>{{ $purchase->item->name }}</p>
        </div>
    @endforeach
</div>
@endif

</div>

@endsection
