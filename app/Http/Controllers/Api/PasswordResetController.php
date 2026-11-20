<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // Always gives the same answer, so nobody can use this to find out which emails have accounts.
    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|string|email']);

        Password::sendResetLink($request->only('email'));

        return response()->json([
            'message' => 'If that email has an account, a reset link has been sent.',
        ]);
    }

    public function reset(Request $request)
    {
        $fields = $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset($fields, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            // Sign the account out everywhere
            $user->tokens()->delete();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PasswordReset) {
            return response()->json([
                'message' => 'This reset link is invalid or has expired.',
            ], 422);
        }

        return response()->json([
            'message' => 'Your password has been reset. You can now log in.',
        ]);
    }
}