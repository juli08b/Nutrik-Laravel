<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Descuento;
use App\Models\UsuarioSistema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function index(): View
    {
        $descuentos = Descuento::with('usuario')->orderBy('Id_descuento')->get();

        return view('descuentos.index', compact('descuentos'));
    }

    public function show(string $id): View
    {
        $descuento = Descuento::with('usuario')->findOrFail($id);

        return view('descuentos.show', compact('descuento'));
    }

    public function create(): View
    {
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('descuentos.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Valor_descuento' => ['required', 'numeric'],
            'Fecha_inicio' => ['required', 'date'],
            'Fecha_fin' => ['required', 'date', 'after_or_equal:Fecha_inicio'],
            'Id_usuario' => ['required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        Descuento::create($validated);

        return redirect()->route('descuentos.index')->with('success', 'Descuento creado con éxito.');
    }

    public function edit(string $id): View
    {
        $descuento = Descuento::findOrFail($id);
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('descuentos.edit', compact('descuento', 'usuarios'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Valor_descuento' => ['sometimes', 'required', 'numeric'],
            'Fecha_inicio' => ['sometimes', 'required', 'date'],
            'Fecha_fin' => ['sometimes', 'required', 'date', 'after_or_equal:Fecha_inicio'],
            'Id_usuario' => ['sometimes', 'required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        Descuento::findOrFail($id)->update($validated);

        return redirect()->route('descuentos.index')->with('success', 'Descuento actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        Descuento::findOrFail($id)->delete();

        return redirect()->route('descuentos.index')->with('success', 'Descuento eliminado correctamente.');
    }
}
