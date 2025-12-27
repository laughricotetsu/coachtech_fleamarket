
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endpush

@section('content')
<div class="profile-container">

    <h2 class="profile-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- アイコン --}}
        <div class="profile-image-area">
            <div class="profile-image-circle">
                {{-- 画像未設定時 --}}
            </div>

            <label class="image-upload-button">
                画像を選択する
                <input type="file" name="avatar_image" hidden>
            </label>
            @error('avatar_image')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}">
            @error('postal_code')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}">
            @error('address')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', auth()->user()->building) }}">
            @error('building')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="update-button">更新する</button>
    </form>
</div>
@endsection
