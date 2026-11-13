<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Only these fields are ever sent to the client (never the password or its hash).
    public static function safeAccount($account): array
    {
        return [
            'id' => $account->id,
            'name' => $account->name,
            'email' => $account->email,
            'role' => $account instanceof Admin ? 'admin' : 'user',
        ];
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Only these three fields are used, so a role can never be chosen at registration.
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'user' => self::safeAccount($user),
            'token' => $token,
        ], 201);
    }

    // One login for everyone: customers are in the users table, administrators in the admins table.
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $account = User::where('email', $fields['email'])->first()
            ?? Admin::where('email', $fields['email'])->first();

        if (! $account || ! Hash::check($fields['password'], $account->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $tokenName = $account instanceof Admin ? 'admintoken' : 'myapptoken';

        return response()->json([
            'user' => self::safeAccount($account),
            'token' => $account->createToken($tokenName)->plainTextToken,
        ], 200);
    }

    // Kept for the earlier admin-only login. It returns the same safe fields.
    public function adminLogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $fields['email'])->first();

        if (! $admin || ! Hash::check($fields['password'], $admin->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $safe = self::safeAccount($admin);

        return response()->json([
            'admin' => $safe,
            'user' => $safe,
            'token' => $admin->createToken('admintoken')->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke only the token used for this request.
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}