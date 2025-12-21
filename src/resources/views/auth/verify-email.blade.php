@extends('layouts.auth')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endpush

@section('content')
<div class="verify-wrapper">
    <p class="verify-text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <a href="#" class="verify-button">認証はこちらから</a>

    <div class="verify-resend">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-link">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection
