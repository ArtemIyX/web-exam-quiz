<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', true);
    }

    public function loginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/');
        } else {
            // Authentication failed
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Invalid email or password',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
