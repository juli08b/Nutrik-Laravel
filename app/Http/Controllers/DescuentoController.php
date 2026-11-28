<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    // Listo todos los descuentos con el usuario asociado
    public function index()
    {
        $descuentos = Descuento::with('usuario')
            ->orderBy('id_descuento', 'desc')
            ->get();

        return response()->json(['data' => $descuentos], 200);
    }

    // Registro un nuevo descuento
    public function store(Request $request)
    {
        $datos = $request->validate([
            'valor_descuento' => 'required|numeric|min:0',
            'fecha_inicio'    => 'required|date',
            'fecha_fin'       => 'required|date|after_or_equal:fecha_inicio',
            'id_usuario'      => 'required|exists:usuarios_sistemas,id_usuario',
        ]);

        $descuento = Descuento::create($datos);
        $descuento->load('usuario');

        return response()->json([
            'message' => 'Descuento creado correctamente',
            'data'    => $descuento,
        ], 201);
    }

    // Consulto un descuento específico por id_descuento
    public function show($id)
    {
        $descuento = Descuento::with('usuario')
            ->where('id_descuento', $id)
            ->first();

        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        return response()->json(['data' => $descuento], 200);
    }

    // Actualizo un descuento existente
    public function update(Request $request, $id)
    {
        $descuento = Descuento::where('id_descuento', $id)->first();

        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $datos = $request->validate([
            'valor_descuento' => 'sometimes|required|numeric|min:0',
            'fecha_inicio'    => 'sometimes|required|date',
            'fecha_fin'       => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'id_usuario'      => 'sometimes|required|exists:usuarios_sistemas,id_usuario',
        ]);

        $descuento->update($datos);
        $descuento->load('usuario');

        return response()->json([
            'message' => 'Descuento actualizado correctamente',
            'data'    => $descuento,
        ], 200);
    }

    // Elimino un descuento
    public function destroy($id)
    {
        $descuento = Descuento::where('id_descuento', $id)->first();

        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $descuento->delete();

        return response()->json(['message' => 'Descuento eliminado correctamente'], 200);
    }
}