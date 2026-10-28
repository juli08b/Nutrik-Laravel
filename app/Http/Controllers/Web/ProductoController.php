<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')->orderBy('Id_producto')->get();

        return view('productos.index', compact('productos'));
    }

    public function show(string $id): View
    {
        $producto = Producto::with('categoria')->findOrFail($id);

        return view('productos.show', compact('producto'));
    }

    public function create(): View
    {
        $categorias = Categoria::query()->orderBy('Id_categoria')->get();

        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Nombre_producto' => ['required', 'string', 'max:100'],
            'Precio' => ['required', 'numeric'],
            'Id_categoria' => ['required', 'exists:categorias,Id_categoria'],
            'Descripcion' => ['nullable', 'string'],
            'Stock' => ['nullable', 'integer', 'min:0'],
            'Imagen' => ['nullable', 'string', 'max:500'],
            'Estado' => ['nullable', 'string', 'max:20'],
            'Vendedor' => ['nullable', 'string', 'max:100'],
        ]);

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit(string $id): View
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::query()->orderBy('Id_categoria')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Nombre_producto' => ['sometimes', 'required', 'string', 'max:100'],
            'Precio' => ['sometimes', 'required', 'numeric'],
            'Id_categoria' => ['sometimes', 'required', 'exists:categorias,Id_categoria'],
            'Descripcion' => ['nullable', 'string'],
            'Stock' => ['nullable', 'integer', 'min:0'],
            'Imagen' => ['nullable', 'string', 'max:500'],
            'Estado' => ['nullable', 'string', 'max:20'],
            'Vendedor' => ['nullable', 'string', 'max:100'],
        ]);

        Producto::findOrFail($id)->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        Producto::findOrFail($id)->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
