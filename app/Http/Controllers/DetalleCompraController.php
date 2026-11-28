<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    // Listo todos los detalles de compra con su pedido y producto
    public function index()
    {
        $detalles = DetalleCompra::with(['pedido', 'producto'])
            ->orderBy('id_detalle', 'desc')
            ->get();

        return response()->json(['data' => $detalles], 200);
    }

    // Registro un nuevo detalle de compra
    public function store(Request $request)
    {
        $datos = $request->validate([
            'precio_unitario' => 'required|numeric|min:0',
            'subtotal'        => 'required|numeric|min:0',
            'cantidad'        => 'required|integer|min:1',
            'id_pedido'       => 'required|exists:pedidos,id_pedido',
            'id_producto'     => 'required|exists:productos,id_producto',
        ]);

        $detalle = DetalleCompra::create($datos);
        $detalle->load(['pedido', 'producto']);

        return response()->json([
            'message' => 'Detalle de compra creado correctamente',
            'data'    => $detalle,
        ], 201);
    }

    // Consulto un detalle de compra por id_detalle
    public function show($id)
    {
        $detalle = DetalleCompra::with(['pedido', 'producto'])
            ->where('id_detalle', $id)
            ->first();

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        return response()->json(['data' => $detalle], 200);
    }

    // Actualizo un detalle de compra
    public function update(Request $request, $id)
    {
        $detalle = DetalleCompra::where('id_detalle', $id)->first();

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        $datos = $request->validate([
            'precio_unitario' => 'sometimes|required|numeric|min:0',
            'subtotal'        => 'sometimes|required|numeric|min:0',
            'cantidad'        => 'sometimes|required|integer|min:1',
            'id_pedido'       => 'sometimes|required|exists:pedidos,id_pedido',
            'id_producto'     => 'sometimes|required|exists:productos,id_producto',
        ]);

        $detalle->update($datos);
        $detalle->load(['pedido', 'producto']);

        return response()->json([
            'message' => 'Detalle de compra actualizado correctamente',
            'data'    => $detalle,
        ], 200);
    }

    // Elimino un detalle de compra
    public function destroy($id)
    {
        $detalle = DetalleCompra::where('id_detalle', $id)->first();

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        $detalle->delete();

        return response()->json(['message' => 'Detalle de compra eliminado correctamente'], 200);
    }
}