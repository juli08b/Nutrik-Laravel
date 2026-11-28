<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioSistemaController extends Controller
{
    // Listo todos los usuarios registrados en el sistema
    public function index()
    {
        $usuarios = UsuarioSistema::orderBy('id_usuario', 'desc')->get();
        return response()->json(['data' => $usuarios], 200);
    }

    // Registro un nuevo usuario (solo un administrador puede asignar roles administrativos)
    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());

        $auth = $request->user();
        $esAdmin = $auth && method_exists($auth, 'esAdmin') && $auth->esAdmin();
        $tipo = $request->input('tipo_usuario', 'cliente');

        if (!$esAdmin && $tipo !== 'cliente') {
            return response()->json([
                'message' => 'No autorizado para crear este tipo de usuario.',
            ], 403);
        }

        if (!in_array($tipo, ['admin', 'admin_tienda', 'cliente'], true)) {
            return response()->json([
                'message' => 'Tipo de usuario no válido.',
            ], 422);
        }

        $datos['tipo_usuario'] = $tipo;

        if (!empty($datos['contrasena'])) {
            $datos['contrasena'] = Hash::make($datos['contrasena']);
        }

        $usuario = UsuarioSistema::create($datos);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data'    => $usuario,
        ], 201);
    }

    // Consulto el perfil de un usuario específico
    public function show(Request $request, $id)
    {
        if (!$this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('id_usuario', $id)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['data' => $usuario], 200);
    }

    // Actualizo los datos de un usuario existente
    public function update(Request $request, $id)
    {
        if (!$this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('id_usuario', $id)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $datos = $request->validate($this->reglas($usuario->id_usuario, true));

        $auth = $request->user();
        $esAdmin = $auth && method_exists($auth, 'esAdmin') && $auth->esAdmin();

        if (!$esAdmin) {
            unset($datos['tipo_usuario']);
        }

        if (!empty($datos['contrasena'])) {
            $datos['contrasena'] = Hash::make($datos['contrasena']);
        } else {
            unset($datos['contrasena']);
        }

        $usuario->update($datos);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data'    => $usuario,
        ], 200);
    }

    // Elimino un usuario del sistema
    public function destroy(Request $request, $id)
    {
        if (!$this->puedeGestionarUsuario($request, (int) $id)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $usuario = UsuarioSistema::where('id_usuario', $id)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    // Valido credenciales de inicio de sesión y genero token si está disponible
    public function login(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'contrasena' => 'required|string',
        ]);

        $usuario = UsuarioSistema::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return response()->json(['message' => 'Correo o contraseña incorrectos.'], 401);
        }

        $token = method_exists($usuario, 'createToken')
            ? $usuario->createToken('cliente-api')->plainTextToken
            : null;

        return response()->json([
            'message' => 'Sesión iniciada correctamente',
            'data'    => $usuario,
            'usuario' => $usuario,
            'token'   => $token,
        ], 200);
    }

    // Verifico si un correo electrónico ya está registrado
    public function verificar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $existe = UsuarioSistema::where('email', $request->email)->exists();

        return response()->json(['existe' => $existe], 200);
    }

    // Restablezco la contraseña de una cuenta verificada
    public function restablecer(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'contrasena' => 'required|string|min:6|max:255',
        ]);

        $usuario = UsuarioSistema::where('email', $request->email)->first();

        if (!$usuario) {
            return response()->json(['message' => 'No existe una cuenta con ese correo.'], 404);
        }

        $auth = $request->user();
        $esAdmin = $auth && method_exists($auth, 'esAdmin') && $auth->esAdmin();

        if ($auth && !$esAdmin && (int) $auth->id_usuario !== (int) $usuario->id_usuario) {
            return response()->json(['message' => 'No autorizado para cambiar esta contraseña.'], 403);
        }

        $usuario->update([
            'contrasena' => Hash::make($request->contrasena),
        ]);

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }

    // Verifico permisos del usuario autenticado sobre el perfil objetivo
    private function puedeGestionarUsuario(Request $request, int $id): bool
    {
        $auth = $request->user();
        if (!$auth) {
            return true;
        }
        if (method_exists($auth, 'esAdmin') && $auth->esAdmin()) {
            return true;
        }
        return (int) $auth->id_usuario === $id;
    }

    // Defino las reglas de validación reutilizables para crear y actualizar usuarios
    private function reglas(?int $ignorarId = null, bool $parcial = false): array
    {
        $requerido = $parcial ? 'sometimes|required' : 'required';

        return [
            'tipo_usuario'      => 'nullable|string|max:40',
            'nombre_usuario'    => "{$requerido}|string|max:50",
            'apellidos_usuario' => "{$requerido}|string|max:50",
            'email'             => "{$requerido}|email|max:100|unique:usuarios_sistemas,email" . ($ignorarId ? ",{$ignorarId},id_usuario" : ''),
            'telefono'          => 'nullable|string|max:20',
            'contrasena'        => "{$requerido}|string|min:6|max:255",
            'direccion'         => 'nullable|string|max:150',
            'ciudad'            => 'nullable|string|max:80',
            'genero'            => 'nullable|string|max:30',
            'alergias'          => 'nullable|string',
            'dieta'             => 'nullable|string|max:80',
            'objetivo_salud'    => 'nullable|string|max:100',
            'nivel_actividad'   => 'nullable|string|max:50',
            'tipo_productos'    => 'nullable|string|max:100',
            'nombre_tienda'     => 'nullable|string|max:100',
            'horario_atencion'  => 'nullable|string|max:100',
            'razon_social'      => 'nullable|string|max:150',
            'rubro'             => 'nullable|string|max:100',
            'fotoPosition'      => 'nullable|string|max:10',
        ];
    }
}