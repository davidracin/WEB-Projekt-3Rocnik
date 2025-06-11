<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // Log in the user after registration

        return redirect()->route('dashboard');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string', // Changed from 'email' to 'login'
            'password' => 'required|string',
        ]);

        // Determine if the input is an email or name
        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        $loginCredentials = [
            $loginField => $credentials['login'],
            'password' => $credentials['password']
        ];

        if (Auth::attempt($loginCredentials)) { // Attempt login with credentials
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'Neplatné přihlašovací údaje.',
        ])->onlyInput('login');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Show dashboard
    public function dashboard()
    {
        return view('dashboard', ['user' => Auth::user()]); // Pass authenticated user
    }
}
