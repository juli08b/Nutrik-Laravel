<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioSistemaController extends Controller
{
    public function index()
    {
        return response()->json(UsuarioSistema::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->reglas());

        // Registro público: nunca permitir crear cuentas administrativas.
        $tipo = strtolower((string) ($validated['Tipo_usuario'] ?? 'cliente'));
        if (in_array($tipo, ['admin', 'administrador'], true)) {
            return response()->json(['message' => 'No autorizado para crear este tipo de usuario.'], 403);
        }
        $validated['Tipo_usuario'] = 'Cliente';

        if (! empty($validated['Contrasena'])) {
            $validated['Contrasena'] = Hash::make($validated['Contrasena']);
        }

        $usuario = UsuarioSistema::create($validated);

        return response()->json(['message' => 'Usuario creado con éxito', 'data' => $usuario], 201);
    }

    private function puedeGestionarUsuario(Request $request, int $id): bool
    {
        $auth = $request->user();
        if (! $auth) return false;
        if (method_exists($auth, 'isAdmin') && $auth->isAdmin()) return true;
        $authId = $auth->Id_usuario ?? $auth->id ?? null;
        return $authId !== null && (int) $authId === (int) $id;
    }

    public function show(Request $request, $id)
    {
        if (! $this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('Id_usuario', $id)->first();
        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario, 200);
    }

    public function update(Request $request, $id)
    {
        if (! $this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('Id_usuario', $id)->first();
        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate($this->reglas($usuario->Id_usuario, true));

        $auth = $request->user();
        $esAdmin = $auth && method_exists($auth, 'isAdmin') && $auth->isAdmin();
        if (! $esAdmin) {
            unset($validated['Tipo_usuario']);
        }

        if (! empty($validated['Contrasena'])) {
            $validated['Contrasena'] = Hash::make($validated['Contrasena']);
        } else {
            unset($validated['Contrasena']);
        }

        $usuario->update($validated);

        return response()->json(['message' => 'Usuario actualizado con éxito', 'data' => $usuario], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (! $this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('Id_usuario', $id)->first();
        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'Contrasena' => 'required|string',
        ]);

        $usuario = UsuarioSistema::where('Email', $request->Email)->first();

        if (! $usuario || ! $usuario->Contrasena || ! Hash::check($request->Contrasena, $usuario->Contrasena)) {
            return response()->json(['message' => 'Correo o contraseña incorrectos.'], 401);
        }

        return response()->json([
            'message' => 'Sesión iniciada',
            'data' => $usuario,
            'token' => $usuario->createToken('cliente-api')->plainTextToken,
        ], 200);
    }

    public function verificar(Request $request)
    {
        $request->validate(['Email' => 'required|email']);

        $existe = UsuarioSistema::where('Email', $request->Email)->exists();

        return response()->json(['existe' => $existe], 200);
    }

    public function restablecer(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'Contrasena' => 'required|string|min:8',
        ]);

        $usuario = UsuarioSistema::where('Email', $request->Email)->first();

        if (! $usuario) {
            return response()->json(['message' => 'No existe una cuenta con ese correo.'], 404);
        }

        $auth = $request->user();
        $esAdmin = $auth && method_exists($auth, 'isAdmin') && $auth->isAdmin();
        $esPropietario = $auth
            && (int) ($auth->Id_usuario ?? $auth->id ?? 0) === (int) $usuario->Id_usuario;

        if (! $esAdmin && ! $esPropietario) {
            return response()->json(['message' => 'No autorizado para cambiar esta contraseña.'], 403);
        }

        $usuario->update(['Contrasena' => Hash::make($request->Contrasena)]);

        return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
    }

    private function reglas(?int $ignorarId = null, bool $parcial = false): array
    {
        $requerido = $parcial ? 'sometimes|required' : 'required';

        return [
            'Tipo_usuario' => $requerido.'|string|max:50',
            'NombreUno_usuario' => $requerido.'|string|max:50',
            'NombreDos_usuario' => 'nullable|string|max:50',
            'ApellidoDos_usuario' => $requerido.'|string|max:50',
            'SegundoApellido' => 'nullable|string|max:50',
            'Telefono' => 'nullable|string|max:20',
            'Email' => [
                $parcial ? 'sometimes' : 'required', 'required', 'email', 'max:100',
                Rule::unique('usuarios_sistemas', 'Email')->ignore($ignorarId, 'Id_usuario'),
            ],
            'Contrasena' => 'nullable|string|min:8',
            'Direccion' => 'nullable|string|max:255',
            'Fecha_nacimiento' => 'nullable|date',
            'Genero' => 'nullable|string|max:30',
            'Estatura' => 'nullable|string|max:10',
            'Peso' => 'nullable|string|max:10',
            'Actividad' => 'nullable|string|max:30',
            'Objetivo' => 'nullable|string|max:30',
            'Alergia' => 'nullable|string|max:100',
            'Dieta' => 'nullable|string|max:50',
            'Restricciones' => 'nullable|string',
            'NombreNegocio' => 'nullable|string|max:100',
            'Nit' => 'nullable|string|max:30',
            'Ciudad' => 'nullable|string|max:50',
            'TipoProductos' => 'nullable|string|max:100',
            'DescripcionNegocio' => 'nullable|string',
            'Foto' => 'nullable|string',
            'FotoPosicion' => 'nullable|string|max:10',
        ];
    }
}
