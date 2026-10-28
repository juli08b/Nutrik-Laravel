<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::query()->orderBy('Id_categoria')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function show(string $id): View
    {
        $categoria = Categoria::with('productos')->findOrFail($id);

        return view('categorias.show', compact('categoria'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Nombre_categoria' => ['required', 'string', 'max:50'],
            'Descripccion' => ['nullable', 'string', 'max:400'],
            'Tipo_producto' => ['required', 'string', 'max:50'],
        ]);

        Categoria::create($validated);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    public function edit(string $id): View
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Nombre_categoria' => ['sometimes', 'required', 'string', 'max:50'],
            'Descripccion' => ['nullable', 'string', 'max:400'],
            'Tipo_producto' => ['sometimes', 'required', 'string', 'max:50'],
        ]);

        Categoria::findOrFail($id)->update($validated);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        Categoria::findOrFail($id)->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
