<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return response()->json(Pedido::with(['usuario', 'detalleCompras'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Estado' => 'required|string|max:50',
            'Fecha_salida' => 'required|date',
            'Fecha_Llegada' => 'required|date|after_or_equal:Fecha_salida',
            'Metodo_pago' => 'required|string|max:50',
            'Subtotal' => 'required|numeric|min:0',
            'Costo_envio' => 'required|numeric|min:0',
            'Total_pedido' => 'required|numeric|min:0',
            'Direccion_envio' => 'required|string|max:255',
            'Ciudad_envio' => 'required|string|max:100',
            'Id_usuario' => 'required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $pedido = Pedido::create($validated);

        return response()->json(['message' => 'Pedido creado con éxito', 'data' => $pedido], 201);
    }

    public function show($id)
    {
        $pedido = Pedido::where('Id_pedido', $id)->with(['usuario', 'detalleCompras'])->first();
        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido, 200);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::where('Id_pedido', $id)->first();
        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $validated = $request->validate([
            'Estado' => 'sometimes|required|string|max:50',
            'Fecha_salida' => 'sometimes|required|date',
            'Fecha_Llegada' => 'sometimes|required|date|after_or_equal:Fecha_salida',
            'Metodo_pago' => 'sometimes|required|string|max:50',
            'Subtotal' => 'sometimes|required|numeric|min:0',
            'Costo_envio' => 'sometimes|required|numeric|min:0',
            'Total_pedido' => 'sometimes|required|numeric|min:0',
            'Direccion_envio' => 'sometimes|required|string|max:255',
            'Ciudad_envio' => 'sometimes|required|string|max:100',
            'Id_usuario' => 'sometimes|required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $pedido->update($validated);

        return response()->json(['message' => 'Pedido actualizado con éxito', 'data' => $pedido], 200);
    }

    public function destroy($id)
    {
        $pedido = Pedido::where('Id_pedido', $id)->first();
        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado correctamente'], 200);
    }
}
