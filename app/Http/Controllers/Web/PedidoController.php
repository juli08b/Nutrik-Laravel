<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\UsuarioSistema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with(['usuario', 'detalleCompras'])->orderBy('Id_pedido')->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function show(string $id): View
    {
        $pedido = Pedido::with(['usuario', 'detalleCompras'])->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    public function create(): View
    {
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('pedidos.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Estado' => ['required', 'string', 'max:50'],
            'Fecha_salida' => ['required', 'date'],
            'Fecha_Llegada' => ['required', 'date', 'after_or_equal:Fecha_salida'],
            'Metodo_pago' => ['required', 'string', 'max:50'],
            'Subtotal' => ['required', 'numeric', 'min:0'],
            'Costo_envio' => ['required', 'numeric', 'min:0'],
            'Total_pedido' => ['required', 'numeric', 'min:0'],
            'Direccion_envio' => ['required', 'string', 'max:255'],
            'Ciudad_envio' => ['required', 'string', 'max:100'],
            'Id_usuario' => ['required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        Pedido::create($validated);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado con éxito.');
    }

    public function edit(string $id): View
    {
        $pedido = Pedido::findOrFail($id);
        $usuarios = UsuarioSistema::query()->orderBy('Id_usuario')->get();

        return view('pedidos.edit', compact('pedido', 'usuarios'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'Estado' => ['sometimes', 'required', 'string', 'max:50'],
            'Fecha_salida' => ['sometimes', 'required', 'date'],
            'Fecha_Llegada' => ['sometimes', 'required', 'date', 'after_or_equal:Fecha_salida'],
            'Metodo_pago' => ['sometimes', 'required', 'string', 'max:50'],
            'Subtotal' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Costo_envio' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Total_pedido' => ['sometimes', 'required', 'numeric', 'min:0'],
            'Direccion_envio' => ['sometimes', 'required', 'string', 'max:255'],
            'Ciudad_envio' => ['sometimes', 'required', 'string', 'max:100'],
            'Id_usuario' => ['sometimes', 'required', 'exists:usuarios_sistemas,Id_usuario'],
        ]);

        Pedido::findOrFail($id)->update($validated);

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        Pedido::findOrFail($id)->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
