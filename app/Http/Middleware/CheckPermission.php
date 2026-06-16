<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Cek apakah user memiliki salah satu permission yang diizinkan
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        foreach ($permissions as $permission) {
            if (auth()->user()->can($permission)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access. Required permission: ' . implode(', ', $permissions));
    }
}