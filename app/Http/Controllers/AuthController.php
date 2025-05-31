<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Form Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:guru,murid',
        ]);

        $user = User::create($request->only('name', 'email', 'role', 'password'));

        Auth::login($user);

        return $this->redirectToDashboard();
    }

    // Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToDashboard()
    {
        $user = Auth::user();
        return match ($user->role) {
            'admin' => redirect()->route('admin.index')->with('success', 'Welcome back, Admin!'),
            'guru' => redirect()->route('guru.index')->with('success', 'Welcome back, Guru!'),
            'murid' => redirect()->route('murid.index')->with('success', 'Welcome back, Murid!'),
        };
    }
}
