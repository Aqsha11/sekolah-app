<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfilApiController extends Controller
{
    /**
     * Ambil profil user yang sedang login
     * GET /api/v1/profil
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'avatar' => $user->avatar ? asset('storage/avatars/' . $user->avatar) : null,
            ],
        ]);
    }
}
