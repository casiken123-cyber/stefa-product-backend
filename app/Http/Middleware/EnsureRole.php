<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $account = $request->user();

        $allowed = match ($role) {
            'admin' => $account instanceof Admin,
            'customer' => $account instanceof User,
            default => false,
        };

        if (! $allowed) {
            return response()->json([
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        }

        return $next($request);
    }
}