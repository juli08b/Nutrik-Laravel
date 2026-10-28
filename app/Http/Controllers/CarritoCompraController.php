<?php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use Illuminate\Http\Request;

class CarritoCompraController extends Controller
{
    public function index()
    {
        return response()->json(CarritoCompra::with('usuario')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Id_producto' => 'nullable|integer|exists:productos,Id_producto',
            'Nombre_producto' => 'nullable|string|max:100',
            'Precio_unitario' => 'nullable|numeric|min:0',
            'Imagen' => 'nullable|string|max:500',
            'Cantidad' => 'required|integer|min:1',
            'Total' => 'required|numeric|min:0',
            'Id_usuario' => 'required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $carrito = CarritoCompra::create($validated);

        return response()->json(['message' => 'Ítem agregado al carrito con éxito', 'data' => $carrito], 201);
    }

    public function show($id)
    {
        // Nota: Respetando tu llave primaria Id_carrite del diagrama
        $carrito = CarritoCompra::where('Id_carrite', $id)->with('usuario')->first();
        if (! $carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        return response()->json($carrito, 200);
    }

    public function update(Request $request, $id)
    {
        $carrito = CarritoCompra::where('Id_carrite', $id)->first();
        if (! $carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        $validated = $request->validate([
            'Id_producto' => 'nullable|integer|exists:productos,Id_producto',
            'Nombre_producto' => 'nullable|string|max:100',
            'Precio_unitario' => 'nullable|numeric|min:0',
            'Imagen' => 'nullable|string|max:500',
            'Cantidad' => 'sometimes|required|integer|min:1',
            'Total' => 'sometimes|required|numeric|min:0',
            'Id_usuario' => 'sometimes|required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $carrito->update($validated);

        return response()->json(['message' => 'Carrito actualizado con éxito', 'data' => $carrito], 200);
    }

    public function destroy($id)
    {
        $carrito = CarritoCompra::where('Id_carrite', $id)->first();
        if (! $carrito) {
            return response()->json(['message' => 'Registro de carrito no encontrado'], 404);
        }

        $carrito->delete();

        return response()->json(['message' => 'Ítem eliminado del carrito correctamente'], 200);
    }
}
