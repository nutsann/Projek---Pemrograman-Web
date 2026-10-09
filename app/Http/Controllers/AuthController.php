<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function register(Request $req)
    {
        $validated = $req->validate(['name' => 'required|string', 'email' => 'required|email|unique:users', 'password' => 'required|min:6|confirmed', 'role' => 'required|in:buyer,seller']);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);
        Auth::login($user);

        return redirect($this->homeFor($user))->with('success', 'Registrasi berhasil');
    }

    public function login(Request $req)
    {
        $validated = $req->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($validated, $req->boolean('remember'))) {
            $req->session()->regenerate();

            return redirect()->intended($this->homeFor(Auth::user()))->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Email atau password salah')->onlyInput('email');
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
