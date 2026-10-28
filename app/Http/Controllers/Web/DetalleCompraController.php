<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DetalleCompra;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    public function index(): View
    {
        $detalles = DetalleCompra::with(['pedido', 'producto'])->orderBy('Id_Detalle')->get();

        return view('detalle-compras.index', compact('detalles'));
    }

    public function show(string $id): View
    {
        $detalle = DetalleCompra::with(['pedido', 'producto'])->findOrFail($id);

        return view('detalle-compras.show', compact('detalle'));
    }

    public function create(): View
    {
        $pedidos = Pedido::query()->orderBy('Id_pedido')->get();
        $productos = Producto::query()->orderBy('Id_producto')->get();

        return view('detalle-compras.create', compact('pedidos', 'productos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Precio_unitario' => ['required', 'numeric', 'min:0'],
            'Subtotal' => ['required', 'numeric', 'min:0'],
            'Cantidad' => ['required', 'integer', 'min:1'],
            'Id_pedido' => ['required', 'exists:pedidos,Id_pedido'],
            'Id_producto' => ['required', 'exists:productos,Id_producto'],
        ]);

        DetalleCompra::create($validated);

        return redirect()->route('detalle-compras.index')->with('success', 'Detalle de compra creado con éxito.');
    }

    public function edit(string $id): View
    {
        $detalle = DetalleCompra::findOrFail($id);
        $pedidos = Pedido::query()->orderBy('Id_pedido')->get();
        $productos = Producto::query()->orderBy('Id_producto')->get();

        return view('detalle-compras.edit', compact('detalle', 'pedidos', 'productos'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Precio_unitario' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Subtotal' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Cantidad' => ['sometimes', 'required', 'integer', 'min:1'],
            'Id_pedido' => ['sometimes', 'required', 'exists:pedidos,Id_pedido'],
            'Id_producto' => ['sometimes', 'required', 'exists:productos,Id_producto'],
        ]);

        DetalleCompra::findOrFail($id)->update($validated);

        return redirect()->route('detalle-compras.index')->with('success', 'Detalle de compra actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        DetalleCompra::findOrFail($id)->delete();

        return redirect()->route('detalle-compras.index')->with('success', 'Detalle de compra eliminado correctamente.');
    }
}
