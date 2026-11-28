<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Listo todas las categorías registradas
    public function index()
    {
        $categorias = Categoria::orderBy('id_categoria', 'desc')->get();
        return response()->json(['data' => $categorias], 200);
    }

    // Registro una nueva categoría
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_categoria' => 'required|string|max:50',
            'descripcion'      => 'nullable|string',
            'tipo_producto'    => 'required|string|max:50',
        ]);

        $categoria = Categoria::create($datos);

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data'    => $categoria,
        ], 201);
    }

    // Consulto una categoría junto con sus productos asociados
    public function show($id)
    {
        $categoria = Categoria::with('productos')
            ->where('id_categoria', $id)
            ->first();

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json(['data' => $categoria], 200);
    }

    // Actualizo una categoría existente
    public function update(Request $request, $id)
    {
        $categoria = Categoria::where('id_categoria', $id)->first();

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $datos = $request->validate([
            'nombre_categoria' => 'sometimes|required|string|max:50',
            'descripcion'      => 'nullable|string',
            'tipo_producto'    => 'sometimes|required|string|max:50',
        ]);

        $categoria->update($datos);

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'data'    => $categoria,
        ], 200);
    }

    // Elimino una categoría
    public function destroy($id)
    {
        $categoria = Categoria::where('id_categoria', $id)->first();

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente'], 200);
    }
}