<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get currently authenticated user
     */
    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    public function login(Request $request){
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) ) {
            $request->session()->regenerate();
            return redirect()->intended('/accounting');
        }

        return response()->json(['message' => 'Invalid credentials'], 401);

    }

    /**
     * Logout the authenticated user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully');
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                            'required',
                            'string',
                            'confirmed',
                            'min:8',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
    ],
        ]);

        // Create a new user
        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the accounting page or any other page
        return redirect('/accounting');
    }

}
