@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
<h1>Create your account</h1>
<p class="auth-sub">Get access to adIQ publisher tools and GAM integration.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" class="form-input"
               value="{{ old('name') }}" required autofocus autocomplete="name"
               placeholder="Jane Smith">
        @error('name')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="email">Work email</label>
        <input type="email" id="email" name="email" class="form-input"
               value="{{ old('email') }}" required autocomplete="email"
               placeholder="you@company.com">
        @error('email')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input"
               required minlength="8" autocomplete="new-password"
               placeholder="Minimum 8 characters">
        @error('password')<div class="form-err">{{ $message }}</div>@enderror
    </div>

    <div class="form-group" style="margin-bottom:24px;">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
               required autocomplete="new-password" placeholder="Repeat password">
    </div>

    <button type="submit" class="btn-auth">Create Account</button>
</form>

<p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
