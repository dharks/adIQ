@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
<h1>Welcome back</h1>
<p class="auth-sub">Sign in to your adIQ publisher account.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-input"
               value="{{ old('email') }}" required autofocus autocomplete="email"
               placeholder="you@company.com">
        @error('email')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input"
               required autocomplete="current-password" placeholder="Your password">
    </div>

    <div class="check-row" style="margin-bottom:24px;">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember">Keep me signed in for 30 days</label>
    </div>

    <button type="submit" class="btn-auth">Sign In</button>
</form>

<p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Request access</a></p>
@endsection
