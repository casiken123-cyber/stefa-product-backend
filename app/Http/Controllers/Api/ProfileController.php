<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(['data' => $this->format($request->user())]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        $user->forceFill($validated)->save();

        return response()->json(['data' => $this->format($user)]);
    }

    // Upload or replace the profile picture (JPG, PNG or WEBP, max 2 MB)
    public function avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = $request->user();

        // Delete the old picture so unused files do not pile up
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->forceFill(['avatar' => $path])->save();

        return response()->json(['data' => $this->format($user)]);
    }

    // Remove the profile picture
    public function removeAvatar(Request $request)
    {
        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->forceFill(['avatar' => null])->save();
        }

        return response()->json(['data' => $this->format($user)]);
    }

    // Change the password: the current one must be right, and other devices are signed out
    public function password(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $user->forceFill(['password' => Hash::make($validated['password'])])->save();

        // Keep this device signed in, revoke every other token
        $user->tokens()
            ->where('id', '!=', $request->user()->currentAccessToken()->id)
            ->delete();

        return response()->json(['message' => 'Password updated']);
    }

    private function format($user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'city' => $user->city,
            'address' => $user->address,
            'avatar_url' => $user->avatar ? asset('storage/' . $user->avatar) : null,
        ];
    }
}