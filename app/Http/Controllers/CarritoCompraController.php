<?php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use Illuminate\Http\Request;

class CarritoCompraController extends Controller
{
    // Listo todos los registros del carrito con su usuario y producto
    public function index()
    {
        $carritos = CarritoCompra::with(['usuario', 'producto'])
            ->orderBy('id_carrito', 'desc')
            ->get();

        return response()->json(['data' => $carritos], 200);
    }

    // Agrego un producto al carrito de compras
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_producto'     => 'required|integer|exists:productos,id_producto',
            'nombre_producto' => 'nullable|string|max:100',
            'precio_unitario' => 'nullable|numeric|min:0',
            'imagen'          => 'nullable|string|max:500',
            'cantidad'        => 'required|integer|min:1',
            'id_usuario'      => 'required|exists:usuarios_sistemas,id_usuario',
        ]);

        $carrito = CarritoCompra::create($datos);
        $carrito->load(['usuario', 'producto']);

        return response()->json([
            'message' => 'Ítem agregado al carrito correctamente',
            'data'    => $carrito,
        ], 201);
    }

    // Consulto un registro específico del carrito por id_carrito
    public function show($id)
    {
        $carrito = CarritoCompra::with(['usuario', 'producto'])
            ->where('id_carrito', $id)
            ->first();

        if (!$carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        return response()->json(['data' => $carrito], 200);
    }

    // Actualizo un registro del carrito
    public function update(Request $request, $id)
    {
        $carrito = CarritoCompra::where('id_carrito', $id)->first();

        if (!$carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        $datos = $request->validate([
            'id_producto'     => 'sometimes|required|integer|exists:productos,id_producto',
            'nombre_producto' => 'nullable|string|max:100',
            'precio_unitario' => 'nullable|numeric|min:0',
            'imagen'          => 'nullable|string|max:500',
            'cantidad'        => 'sometimes|required|integer|min:1',
            'id_usuario'      => 'sometimes|required|exists:usuarios_sistemas,id_usuario',
        ]);

        $carrito->update($datos);
        $carrito->load(['usuario', 'producto']);

        return response()->json([
            'message' => 'Carrito actualizado correctamente',
            'data'    => $carrito,
        ], 200);
    }

    // Elimino un ítem del carrito
    public function destroy($id)
    {
        $carrito = CarritoCompra::where('id_carrito', $id)->first();

        if (!$carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        $carrito->delete();

        return response()->json(['message' => 'Ítem eliminado del carrito correctamente'], 200);
    }
}