@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('content')
<h1>Reset your password</h1>
<p class="auth-sub">Enter your account email and we'll send you a reset link.</p>

@if(session('status'))
    <div style="background:#DCFCE7;border:1px solid #BBF7D0;border-radius:8px;padding:12px 16px;font-size:13.5px;color:#15803D;margin-bottom:20px;">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-input"
               value="{{ old('email') }}" required autofocus autocomplete="email"
               placeholder="you@company.com">
        @error('email')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn-auth">Send reset link</button>
</form>

<p class="auth-switch"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
