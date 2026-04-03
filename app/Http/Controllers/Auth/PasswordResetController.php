<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /** GET /forgot-password */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /** POST /forgot-password */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        try {
            $status = Password::sendResetLink($request->only('email'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Password reset mail failed: ' . $e->getMessage());
            // Always return the same message so we don't reveal whether the email exists
            return back()->with('status', 'If that email is registered, a reset link has been sent.');
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'If that email is registered, a reset link has been sent.')
            : back()->withErrors(['email' => __($status)]);
    }

    /** GET /reset-password/{token} */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /** POST /reset-password */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password reset successfully. Please sign in.')
            : back()->withErrors(['email' => __($status)]);
    }
}
