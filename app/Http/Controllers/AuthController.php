<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the request data including the userprofile file
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'userprofile' => 'nullable|image|max:2048', // Max file size 2MB (2048 KB)
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'userprofile' => $request->file('userprofile') ? $request->file('userprofile')->store('profile_images', 'public') : null,
        ]);

        // Assign the 'client' role to the user
        $clientRole = Role::where('name', 'client')->first();
        $user->roles()->attach($clientRole);

        // Return success response
        return response()->json(['message' => 'Registered successfully'], 200);
    }

    /**
     * Authenticate the user and return a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to log in the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Retrieve the authenticated user with their associated role
        $user = Auth::user()->load('roles'); // Load the roles relationship

        // Return response with token and user data including role
        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ], 200);
    }

    /**
     * Log the user out (revoke the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();

        // Return a success message
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Get details of the logged-in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loggedUser(Request $request)
    {
        // Retrieve the authenticated user with their associated role
        $user = Auth::user()->load('roles'); // Load the roles relationship

        // Return response with user data including role
        return response()->json([
            'user' => $user,
        ], 200);
    }
}
