<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'No autenticado.'], 401);
        }

        $esAdmin = false;

        if (method_exists($user, 'isAdmin')) {
            $esAdmin = $user->isAdmin();
        } else {
            $role = strtolower((string) ($user->role ?? $user->Tipo_usuario ?? $user->Rol ?? ''));
            $esAdmin = in_array($role, ['admin', 'administrador'], true);
        }

        if (! $esAdmin) {
            return response()->json(['message' => 'No autorizado. Esta acción es solo para administradores.'], 403);
        }

        return $next($request);
    }
}
