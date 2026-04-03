<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms'    => ['accepted'],
            'country'  => ['required', 'string', 'max:100'],
            'state'    => ['nullable', 'string', 'max:100'],
            'city'     => ['nullable', 'string', 'max:100'],
            'address'  => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'country'  => $validated['country'],
            'state'    => $validated['state'] ?? null,
            'city'     => $validated['city'] ?? null,
            'address'  => $validated['address'] ?? null,
        ]);

        Auth::login($user);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Welcome mail failed: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')
            ->with('flash', 'Account created! Welcome to adIQ.');
    }
}
