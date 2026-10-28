<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        return response()->json(Contacto::orderByDesc('Id_contacto')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => 'required|string|max:100',
            'Email' => 'required|email|max:100',
            'Tipo_solicitud' => 'required|string|max:30',
            'Asunto' => 'required|string|max:150',
            'Mensaje' => 'required|string',
        ]);

        $contacto = Contacto::create($validated);

        return response()->json(['message' => 'Solicitud registrada con éxito', 'data' => $contacto], 201);
    }
}
