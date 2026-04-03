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

    <div style="margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" name="terms" id="terms" value="1"
                   style="width:16px;height:16px;flex-shrink:0;accent-color:var(--teal);cursor:pointer;"
                   {{ old('terms') ? 'checked' : '' }}>
            <label for="terms" style="margin:0;font-size:13.5px;font-weight:400;color:var(--g500);cursor:pointer;line-height:1.4;">
                I agree to the <a href="{{ route('terms') }}" target="_blank" rel="noopener" style="color:var(--teal);text-decoration:none;">Terms of Service</a> and <a href="{{ route('privacy') }}" target="_blank" rel="noopener" style="color:var(--teal);text-decoration:none;">Privacy Policy</a>
            </label>
        </div>
        @error('terms')<div class="form-err" style="margin-top:6px;">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn-auth">Create Account</button>
</form>

<p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
