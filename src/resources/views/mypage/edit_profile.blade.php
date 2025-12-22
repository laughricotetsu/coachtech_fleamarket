@extends('layouts.app')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush


<div class="profile-wrapper">
  <div class="profile-card">
    <h2 class="profile-title">プロフィール設定</h2>


    <form class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        < class="avatar-area">
        <div class="avatar-circle"></div>
            <img src="{{ asset('images/default.png') }}">
            <input type="file" name="profile_image">
            <label class="avatar-button">
                画像を選択する
            <input type="file" hidden>
            </label>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" value="{{ auth()->user()->name }}" disabled>
        </div>

        <div class="form-group">
        <label>郵便番号</label>
        <input type="text" name="postal_code">
        </div>

        <div class="form-group">
        <label>住所</label>
        <input type="text" name="address">
        </div>

        <div class="form-group">
        <label>建物名</label>
        <input type="text" name="building">
        </div>

        <button class="submit-button">更新する</button>
    </form>
</div>
@endsection
