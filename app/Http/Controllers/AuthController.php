<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Register Form
    public function showRegisterForm()
    {
        // Agar user already logged in hai, toh home redirect karein
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.auth.register');
    }

    // Handle Registration
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|max:255|min:3',
        'email' => 'nullable|email|unique:users,email',
        'phone' => [
            'required',
            'digits:10',
            'regex:/^[6-9][0-9]{9}$/',
            'not_regex:/^(.)\1{9}$/', // ❌ 1111111111, 9999999999 block
            'unique:users,phone'
        ],
        'password' => 'required|string|min:6|confirmed',
        'phone_verified' => 'sometimes|boolean',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'phone_verified' => $request->has('phone_verified') ? true : false,
        'phone_verified_at' => $request->has('phone_verified') ? now() : null,
    ]);

    Auth::login($user);

    return redirect()->route('home')->with('success', 'Registration successful! Welcome, ' . $user->name);
}
    // Show Login Form
    public function showLoginForm()
    {
        // Agar user already logged in hai, toh home redirect karein
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user is admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }


            return redirect()->route('home')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email', 'remember'));
    }

    // Handle Logout
    public function logout(Request $request)
    {
        $userName = Auth::user()->name;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Goodbye, ' . $userName . '! See you soon.');
    }
}
