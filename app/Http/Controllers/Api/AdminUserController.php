<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')
            ->withSum(['orders as spent' => fn ($query) => $query->where('status', '!=', 'cancelled')], 'total')
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $users->map(fn ($user) => $this->format($user))]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($validated);

        return response()->json(['data' => $this->format($user->loadCount('orders'))]);
    }

    public function destroy(User $user)
    {
        if ($user->orders()->exists()) {
            return response()->json([
                'message' => 'This user has orders and cannot be deleted.',
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    private function format(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'city' => $user->city,
            'address' => $user->address,
            'orders_count' => (int) ($user->orders_count ?? 0),
            'spent' => (float) ($user->spent ?? 0),
            'created_at' => $user->created_at,
        ];
    }
}
