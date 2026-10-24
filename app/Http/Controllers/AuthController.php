<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $req)
    {
        $req->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($req->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => request('email')]);
    }

    public function resetPassword(Request $req)
    {
        $validated = $req->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset($validated, function ($user, $password) {
            $user->forceFill(['password' => $password])->save();
            Auth::login($user);
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success', 'Password berhasil diperbarui.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function register(Request $req)
    {
        $validated = $req->validate([
            'username' => 'required|string|max:100|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|in:buyer,seller',
        ], [
            'username.required' => 'Username wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'] ?? 'buyer',
        ]);

        Auth::login($user);

        return redirect($this->homeFor($user))->with('success', 'Registrasi berhasil');
    }

    public function login(Request $req)
    {
        $validated = $req->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ], [
            'identifier.required' => 'Email atau username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $field = filter_var($validated['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = [
            $field => $validated['identifier'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials, $req->boolean('remember'))) {
            $req->session()->regenerate();

            return redirect()->intended($this->homeFor(Auth::user()))->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Email/username atau password salah')->withInput($req->only('identifier'));
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil');
    }

    private function homeFor($user)
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'seller' => route('umkm.dashboard'),
            default => route('home'),
        };
    }
}
