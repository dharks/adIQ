@extends('layouts.auth')
@section('title', 'Set New Password')

@section('content')
<h1>Set a new password</h1>
<p class="auth-sub">Choose a strong password for your adIQ account.</p>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-input"
               value="{{ old('email', $email) }}" required autocomplete="email"
               placeholder="you@company.com">
        @error('email')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="password">New password</label>
        <input type="password" id="password" name="password" class="form-input"
               required autocomplete="new-password" placeholder="Minimum 8 characters">
        @error('password')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group" style="margin-bottom:24px;">
        <label for="password_confirmation">Confirm new password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
               required autocomplete="new-password" placeholder="Repeat password">
    </div>

    <button type="submit" class="btn-auth">Reset password</button>
</form>
@endsection
