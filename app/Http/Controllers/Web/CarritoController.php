<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CarritoCompra;
use App\Models\UsuarioSistema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index(): View
    {
        $carrito = CarritoCompra::with('usuario')->orderBy('Id_carrite')->get();

        return view('carrito.index', compact('carrito'));
    }

    public function show(string $id): View
    {
        $item = CarritoCompra::with('usuario')->findOrFail($id);

        return view('carrito.show', compact('item'));
    }

    public function create(): View
    {
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('carrito.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Id_producto' => ['nullable', 'integer', 'exists:productos,Id_producto'],
            'Nombre_producto' => ['nullable', 'string', 'max:100'],
            'Precio_unitario' => ['nullable', 'numeric', 'min:0'],
            'Imagen' => ['nullable', 'string', 'max:500'],
            'Cantidad' => ['required', 'integer', 'min:1'],
            'Total' => ['required', 'numeric', 'min:0'],
            'Id_usuario' => ['required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        CarritoCompra::create($validated);

        return redirect()->route('carrito.index')->with('success', 'Ítem agregado al carrito con éxito.');
    }

    public function edit(string $id): View
    {
        $item = CarritoCompra::findOrFail($id);
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('carrito.edit', compact('item', 'usuarios'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Id_producto' => ['nullable', 'integer', 'exists:productos,Id_producto'],
            'Nombre_producto' => ['nullable', 'string', 'max:100'],
            'Precio_unitario' => ['nullable', 'numeric', 'min:0'],
            'Imagen' => ['nullable', 'string', 'max:500'],
            'Cantidad' => ['sometimes', 'required', 'integer', 'min:1'],
            'Total' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Id_usuario' => ['sometimes', 'required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        CarritoCompra::findOrFail($id)->update($validated);

        return redirect()->route('carrito.index')->with('success', 'Carrito actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        CarritoCompra::findOrFail($id)->delete();

        return redirect()->route('carrito.index')->with('success', 'Ítem eliminado del carrito correctamente.');
    }
}
