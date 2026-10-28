<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Body: { "email": "...", "password": "..." }
     * Devuelve el token Bearer para usar en Postman.
     */
    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no coinciden con nuestros registros.'],
            ]);
        }

        return response()->json([
            'message' => 'Token generado correctamente.',
            'data' => [
                'token' => $user->createToken('api')->plainTextToken,
                'user' => $user->only(['id', 'name', 'email']),
            ],
        ], 200);
    }

    /**
     * POST /api/logout
     * Requiere token Bearer. Revoca el token actual.
     */
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente.'], 200);
    }

    /**
     * GET /api/user
     * Requiere token Bearer. Devuelve el usuario autenticado.
     */
    public function apiUser(Request $request)
    {
        return response()->json(['data' => $request->user()], 200);
    }
}
