<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    public function index()
    {
        return response()->json(DetalleCompra::with(['pedido', 'producto'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Precio_unitario' => 'required|numeric|min:0',
            'Subtotal' => 'required|numeric|min:0',
            'Cantidad' => 'required|integer|min:1',
            'Id_pedido' => 'required|exists:pedidos,Id_pedido',
            'Id_producto' => 'required|exists:productos,Id_producto',
        ]);

        $detalle = DetalleCompra::create($validated);

        return response()->json(['message' => 'Detalle de compra creado con éxito', 'data' => $detalle], 201);
    }

    public function show($id)
    {
        // Nota: Respetando tu llave primaria Id_Detalle del diagrama
        $detalle = DetalleCompra::where('Id_Detalle', $id)->with(['pedido', 'producto'])->first();
        if (! $detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        return response()->json($detalle, 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleCompra::where('Id_Detalle', $id)->first();
        if (! $detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        $validated = $request->validate([
            'Precio_unitario' => 'sometimes|required|numeric|min:0',
            'Subtotal' => 'sometimes|required|numeric|min:0',
            'Cantidad' => 'sometimes|required|integer|min:1',
            'Id_pedido' => 'sometimes|required|exists:pedidos,Id_pedido',
            'Id_producto' => 'sometimes|required|exists:productos,Id_producto',
        ]);

        $detalle->update($validated);

        return response()->json(['message' => 'Detalle de compra actualizado con éxito', 'data' => $detalle], 200);
    }

    public function destroy($id)
    {
        $detalle = DetalleCompra::where('Id_Detalle', $id)->first();
        if (! $detalle) {
            return response()->json(['message' => 'Detalle de compra no encontrado'], 404);
        }

        $detalle->delete();

        return response()->json(['message' => 'Detalle de compra eliminado correctamente'], 200);
    }
}
