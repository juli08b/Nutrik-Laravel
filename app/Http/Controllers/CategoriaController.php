<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nombre_categoria' => 'required|string|max:50',
            'Descripccion' => 'nullable|string|max:400',
            'Tipo_producto' => 'required|string|max:50',
        ]);

        $categoria = Categoria::create($validated);

        return response()->json(['message' => 'Categoría creada con éxito', 'data' => $categoria], 201);
    }

    public function show($id)
    {
        $categoria = Categoria::where('Id_categoria', $id)->with('productos')->first();
        if (! $categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria, 200);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::where('Id_categoria', $id)->first();
        if (! $categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $validated = $request->validate([
            'Nombre_categoria' => 'sometimes|required|string|max:50',
            'Descripccion' => 'nullable|string|max:400',
            'Tipo_producto' => 'sometimes|required|string|max:50',
        ]);

        $categoria->update($validated);

        return response()->json(['message' => 'Categoría actualizada con éxito', 'data' => $categoria], 200);
    }

    public function destroy($id)
    {
        $categoria = Categoria::where('Id_categoria', $id)->first();
        if (! $categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente'], 200);
    }
}
