<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        // Your code logic goes here
        return view('quiz/list');
    }

    public function user()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/');
        }
        // Get the authenticated user
        $user = Auth::user();

        return view('user.details', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $u = Auth::user();
        $user = User::find($u->id); // Replace $userId with the actual user ID
        // Validate the entered password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }
        if(User::where('email', $request->email)
            ->where('id', '!=', $user->id)
            ->exists()) {
            return back()->withErrors(['email'=> 'Email is already taken']);
        }

        $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|string|min:6|confirmed'
                // 'email' => 'required|email|unique:users,email,' . $user->id,
                // 'password' => 'required|string|min:8|confirmed',
            ]);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();
        return redirect()->back()->withInput()->with('message', 'User details updated successfully.');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'old_password_confirmation' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $u = Auth::user();
        $user = User::find($u->id);

        // Verify the old password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The old password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('message', 'Password changed successfully!');
    }

}
