<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function index()
    {
        return response()->json(Descuento::with('usuario')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Valor_descuento' => 'required|numeric',
            'Fecha_inicio' => 'required|date',
            'Fecha_fin' => 'required|date|after_or_equal:Fecha_inicio',
            'Id_usuario' => 'required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $descuento = Descuento::create($validated);

        return response()->json(['message' => 'Descuento creado con éxito', 'data' => $descuento], 201);
    }

    public function show($id)
    {
        $descuento = Descuento::where('Id_descuento', $id)->with('usuario')->first();
        if (! $descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        return response()->json($descuento, 200);
    }

    public function update(Request $request, $id)
    {
        $descuento = Descuento::where('Id_descuento', $id)->first();
        if (! $descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $validated = $request->validate([
            'Valor_descuento' => 'sometimes|required|numeric',
            'Fecha_inicio' => 'sometimes|required|date',
            'Fecha_fin' => 'sometimes|required|date|after_or_equal:Fecha_inicio',
            'Id_usuario' => 'sometimes|required|exists:usuarios_sistemas,Id_usuario',
        ]);

        $descuento->update($validated);

        return response()->json(['message' => 'Descuento actualizado con éxito', 'data' => $descuento], 200);
    }

    public function destroy($id)
    {
        $descuento = Descuento::where('Id_descuento', $id)->first();
        if (! $descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $descuento->delete();

        return response()->json(['message' => 'Descuento eliminado correctamente'], 200);
    }
}
