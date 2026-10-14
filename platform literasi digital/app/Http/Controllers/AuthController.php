<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    private function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login', ['showRegister' => false]);
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login', ['showRegister' => true]);
    }

    public function register(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => $this->normalizeEmail($request->input('email', '')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Masuk menggunakan kata sandi yang dibuat di Kilas Ilmu.',
        ]);

        // KUNCI UTAMA: Hash password sebelum disimpan ke database
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function login(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => $this->normalizeEmail($request->input('email', '')),
        ]);

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = $validated['email'].'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.',
            ]);
        }

        if (! Auth::attempt($validated, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi tidak sesuai. Gunakan kata sandi yang dibuat di Kilas Ilmu, bukan kata sandi Gmail.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}