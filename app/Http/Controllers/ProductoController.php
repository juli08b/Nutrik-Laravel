<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Listo todos los productos con su categoría
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('id_producto', 'desc')
            ->get();

        return response()->json(['data' => $productos], 200);
    }

    // Registro un nuevo producto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'precio'          => 'required|numeric|min:0',
            'id_categoria'    => 'required|exists:categorias,id_categoria',
            'descripcion'     => 'nullable|string',
            'stock'           => 'nullable|integer|min:0',
            'imagen'          => 'nullable|string|max:500',
            'estado'          => 'nullable|string|max:20',
            'vendedor'        => 'nullable|string|max:100',
        ]);

        $producto = Producto::create($datos);
        $producto->load('categoria');

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data'    => $producto,
        ], 201);
    }

    // Consulto un producto específico por id_producto
    public function show($id)
    {
        $producto = Producto::with('categoria')
            ->where('id_producto', $id)
            ->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json(['data' => $producto], 200);
    }

    // Actualizo un producto existente
    public function update(Request $request, $id)
    {
        $producto = Producto::where('id_producto', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $datos = $request->validate([
            'nombre_producto' => 'sometimes|required|string|max:100',
            'precio'          => 'sometimes|required|numeric|min:0',
            'id_categoria'    => 'sometimes|required|exists:categorias,id_categoria',
            'descripcion'     => 'nullable|string',
            'stock'           => 'nullable|integer|min:0',
            'imagen'          => 'nullable|string|max:500',
            'estado'          => 'nullable|string|max:20',
            'vendedor'        => 'nullable|string|max:100',
        ]);

        $producto->update($datos);
        $producto->load('categoria');

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'data'    => $producto,
        ], 200);
    }

    // Elimino un producto
    public function destroy($id)
    {
        $producto = Producto::where('id_producto', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}