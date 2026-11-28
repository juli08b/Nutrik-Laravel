<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Listo todos los mensajes de contacto recibidos
    public function index()
    {
        $contactos = Contacto::orderBy('id_contacto', 'desc')->get();
        return response()->json(['data' => $contactos], 200);
    }

    // Registro una nueva solicitud de contacto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'         => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'tipo_solicitud' => 'required|string|max:30',
            'mensaje'        => 'required|string',
        ]);

        $contacto = Contacto::create($datos);

        return response()->json([
            'message' => 'Solicitud registrada correctamente',
            'data'    => $contacto,
        ], 201);
    }

    // Consulto un mensaje de contacto por id_contacto
    public function show($id)
    {
        $contacto = Contacto::where('id_contacto', $id)->first();

        if (!$contacto) {
            return response()->json(['message' => 'Solicitud de contacto no encontrada'], 404);
        }

        return response()->json(['data' => $contacto], 200);
    }

    // Elimino un mensaje de contacto
    public function destroy($id)
    {
        $contacto = Contacto::where('id_contacto', $id)->first();

        if (!$contacto) {
            return response()->json(['message' => 'Solicitud de contacto no encontrada'], 404);
        }

        $contacto->delete();

        return response()->json(['message' => 'Solicitud eliminada correctamente'], 200);
    }
}