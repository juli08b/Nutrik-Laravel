<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with('categoria')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nombre_producto' => 'required|string|max:100',
            'Precio' => 'required|numeric',
            'Id_categoria' => 'required|exists:categorias,Id_categoria',
            'Descripcion' => 'nullable|string',
            'Stock' => 'nullable|integer|min:0',
            'Imagen' => 'nullable|string|max:500',
            'Estado' => 'nullable|string|max:20',
            'Vendedor' => 'nullable|string|max:100',
        ]);

        $producto = Producto::create($validated);

        return response()->json(['message' => 'Producto creado con éxito', 'data' => $producto], 201);
    }

    public function show($id)
    {
        $producto = Producto::where('Id_producto', $id)->with('categoria')->first();
        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::where('Id_producto', $id)->first();
        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validated = $request->validate([
            'Nombre_producto' => 'sometimes|required|string|max:100',
            'Precio' => 'sometimes|required|numeric',
            'Id_categoria' => 'sometimes|required|exists:categorias,Id_categoria',
            'Descripcion' => 'nullable|string',
            'Stock' => 'nullable|integer|min:0',
            'Imagen' => 'nullable|string|max:500',
            'Estado' => 'nullable|string|max:20',
            'Vendedor' => 'nullable|string|max:100',
        ]);

        $producto->update($validated);

        return response()->json(['message' => 'Producto actualizado con éxito', 'data' => $producto], 200);
    }

    public function destroy($id)
    {
        $producto = Producto::where('Id_producto', $id)->first();
        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
