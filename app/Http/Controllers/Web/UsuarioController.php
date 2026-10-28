<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UsuarioSistema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function show(string $id): View
    {
        $usuario = UsuarioSistema::findOrFail($id);

        return view('usuarios.show', compact('usuario'));
    }

    public function create(): View
    {
        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        if (! empty($validated['Contrasena'] ?? null)) {
            $validated['Contrasena'] = Hash::make($validated['Contrasena']);
        }

        UsuarioSistema::create($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    public function edit(string $id): View
    {
        $usuario = UsuarioSistema::findOrFail($id);

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $usuario = UsuarioSistema::findOrFail($id);
        $validated = $request->validate($this->rules($usuario->Id_usuario, true));

        if (! empty($validated['Contrasena'] ?? null)) {
            $validated['Contrasena'] = Hash::make($validated['Contrasena']);
        } else {
            unset($validated['Contrasena']);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        UsuarioSistema::findOrFail($id)->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?string $ignoreId = null, bool $partial = false): array
    {
        $required = $partial ? ['sometimes', 'required'] : ['required'];
        $emailRules = $partial ? ['sometimes'] : [];

        return [
            'Tipo_usuario' => [...$required, 'string', 'max:50'],
            'NombreUno_usuario' => [...$required, 'string', 'max:50'],
            'NombreDos_usuario' => ['nullable', 'string', 'max:50'],
            'ApellidoDos_usuario' => [...$required, 'string', 'max:50'],
            'SegundoApellido' => ['nullable', 'string', 'max:50'],
            'Telefono' => ['nullable', 'string', 'max:20'],
            'Email' => [
                ...$emailRules,
                'required',
                'email',
                'max:100',
                Rule::unique('usuarios_sistemas', 'Email')->ignore($ignoreId, 'Id_usuario'),
            ],
            'Contrasena' => ['nullable', 'string', 'min:8'],
            'Direccion' => ['nullable', 'string', 'max:50'],
            'Fecha_nacimiento' => ['nullable', 'date'],
            'Genero' => ['nullable', 'string', 'max:30'],
            'Estatura' => ['nullable', 'string', 'max:10'],
            'Peso' => ['nullable', 'string', 'max:10'],
            'Actividad' => ['nullable', 'string', 'max:30'],
            'Objetivo' => ['nullable', 'string', 'max:30'],
            'Alergia' => ['nullable', 'string', 'max:100'],
            'Dieta' => ['nullable', 'string', 'max:50'],
            'Restricciones' => ['nullable', 'string'],
            'NombreNegocio' => ['nullable', 'string', 'max:100'],
            'Nit' => ['nullable', 'string', 'max:30'],
            'Ciudad' => ['nullable', 'string', 'max:50'],
            'TipoProductos' => ['nullable', 'string', 'max:100'],
            'DescripcionNegocio' => ['nullable', 'string'],
            'Foto' => ['nullable', 'string'],
            'FotoPosicion' => ['nullable', 'string', 'max:10'],
        ];
    }
}
