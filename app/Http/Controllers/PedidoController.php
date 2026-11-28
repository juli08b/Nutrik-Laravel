<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Listo todos los pedidos con su usuario y detalles de compra
    public function index()
    {
        $pedidos = Pedido::with(['usuario', 'detallesCompra'])
            ->orderBy('id_pedido', 'desc')
            ->get();

        return response()->json(['data' => $pedidos], 200);
    }

    // Registro un nuevo pedido
    public function store(Request $request)
    {
        $datos = $request->validate([
            'estado'          => 'required|string|max:50',
            'fecha_salida'    => 'required|date',
            'fecha_llegada'   => 'required|date|after_or_equal:fecha_salida',
            'metodo_pago'     => 'required|string|max:30',
            'subtotal'        => 'required|numeric|min:0',
            'costo_envio'     => 'required|numeric|min:0',
            'total'           => 'required|numeric|min:0',
            'direccion_envio' => 'required|string|max:255',
            'ciudad_envio'    => 'required|string|max:100',
            'id_usuario'      => 'required|exists:usuarios_sistemas,id_usuario',
        ]);

        $pedido = Pedido::create($datos);
        $pedido->load(['usuario', 'detallesCompra']);

        return response()->json([
            'message' => 'Pedido creado correctamente',
            'data'    => $pedido,
        ], 201);
    }

    // Consulto un pedido específico por id_pedido
    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'detallesCompra'])
            ->where('id_pedido', $id)
            ->first();

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json(['data' => $pedido], 200);
    }

    // Actualizo un pedido existente
    public function update(Request $request, $id)
    {
        $pedido = Pedido::where('id_pedido', $id)->first();

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $datos = $request->validate([
            'estado'          => 'sometimes|required|string|max:50',
            'fecha_salida'    => 'sometimes|required|date',
            'fecha_llegada'   => 'sometimes|required|date|after_or_equal:fecha_salida',
            'metodo_pago'     => 'sometimes|required|string|max:30',
            'subtotal'        => 'sometimes|required|numeric|min:0',
            'costo_envio'     => 'sometimes|required|numeric|min:0',
            'total'           => 'sometimes|required|numeric|min:0',
            'direccion_envio' => 'sometimes|required|string|max:255',
            'ciudad_envio'    => 'sometimes|required|string|max:100',
            'id_usuario'      => 'sometimes|required|exists:usuarios_sistemas,id_usuario',
        ]);

        $pedido->update($datos);
        $pedido->load(['usuario', 'detallesCompra']);

        return response()->json([
            'message' => 'Pedido actualizado correctamente',
            'data'    => $pedido,
        ], 200);
    }

    // Elimino un pedido
    public function destroy($id)
    {
        $pedido = Pedido::where('id_pedido', $id)->first();

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado correctamente'], 200);
    }
}