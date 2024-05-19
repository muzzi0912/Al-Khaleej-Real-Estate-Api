<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user has the 'admin' role
            if (!$user->roles->contains('name', 'admin')) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $token = $user->createToken('AdminToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get logged in admin details.
     */
    public function loggedAdmin(Request $request)
    {
        $user = $request->user();

        if (!$user->roles->contains('name', 'admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($user);
    }
}
