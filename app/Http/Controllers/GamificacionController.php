<?php

namespace App\Http\Controllers;

use App\Models\Canje;
use App\Models\Logro;
use App\Models\Pedido;
use App\Models\Punto;
use App\Models\Recompensa;
use App\Models\Reto;
use App\Models\UsuarioLogro;
use App\Models\UsuarioReto;
use App\Services\GamificacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GamificacionController extends Controller
{
    public function dashboard(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $racha = $servicio->asegurarRacha($idUsuario);
        $puntos = $servicio->saldoPuntos($idUsuario);
        $hoy = Carbon::today()->toDateString();
        $retosHoy = UsuarioReto::with('reto')->where('Id_usuario', $idUsuario)->where('Fecha', $hoy)->get();
        $completados = UsuarioReto::where('Id_usuario', $idUsuario)->where('Completado', true)->count();
        $pendientes = $retosHoy->where('Completado', false)->count();
        $logros = UsuarioLogro::with('logro')->where('Id_usuario', $idUsuario)->count();
        $recompensas = Recompensa::where('Activo', true)->count();

        $mensaje = $pendientes > 0
            ? '🎯 ¿Listo para tu reto de hoy?'
            : ($completados > 0 ? '¡Muy bien! Ya completaste tus retos de hoy 💚' : 'Pequeños hábitos construyen grandes resultados.');

        return response()->json([
            'usuarioId' => $idUsuario,
            'puntos' => $puntos,
            'racha' => [
                'actual' => $racha->Racha_actual,
                'mejor' => $racha->Mejor_racha,
                'dias' => $racha->Dias_completados,
            ],
            'retosCompletados' => $completados,
            'progresoSemanal' => [
                'hoy' => $retosHoy->count() ? round(($retosHoy->where('Completado', true)->count() / $retosHoy->count()) * 100) : 0,
                'completadosHoy' => $retosHoy->where('Completado', true)->count(),
                'totalHoy' => $retosHoy->count(),
            ],
            'logros' => $logros,
            'recompensasDisponibles' => $recompensas,
            'mensajeMotivador' => $mensaje,
            'retosHoy' => $retosHoy->map(function ($ur) {
                return [
                    'idUsuarioReto' => $ur->Id_usuario_reto,
                    'idReto' => $ur->Id_reto,
                    'nombre' => $ur->reto?->Nombre,
                    'descripcion' => $ur->reto?->Descripcion,
                    'categoria' => $ur->reto?->Categoria,
                    'icono' => $ur->reto?->Icono,
                    'puntos' => $ur->reto?->Puntos,
                    'completado' => $ur->Completado,
                    'fecha' => $ur->Fecha,
                ];
            })->values(),
        ]);
    }

    public function retos(Request $request, $idUsuario)
    {
        $hoy = Carbon::today()->toDateString();
        $retos = Reto::where('Activo', true)->get();

        foreach ($retos as $reto) {
            UsuarioReto::firstOrCreate(
                ['Id_usuario' => $idUsuario, 'Id_reto' => $reto->Id_reto, 'Fecha' => $hoy],
                ['Completado' => false, 'Puntos_obtenidos' => 0]
            );
        }

        $misRetos = UsuarioReto::with('reto')->where('Id_usuario', $idUsuario)->where('Fecha', $hoy)->get();

        return response()->json($misRetos->map(function ($ur) {
            return [
                'idUsuarioReto' => $ur->Id_usuario_reto,
                'idReto' => $ur->Id_reto,
                'nombre' => $ur->reto->Nombre,
                'descripcion' => $ur->reto->Descripcion,
                'categoria' => $ur->reto->Categoria,
                'icono' => $ur->reto->Icono,
                'puntos' => $ur->reto->Puntos,
                'completado' => $ur->Completado,
                'completadoEn' => $ur->Completado_en,
                'fecha' => $ur->Fecha,
            ];
        })->values());
    }

    public function completarReto(Request $request, $idUsuario, $idUsuarioReto)
    {
        $servicio = new GamificacionService;
        $ur = UsuarioReto::with('reto')->where('Id_usuario_reto', $idUsuarioReto)->where('Id_usuario', $idUsuario)->first();

        if (! $ur) {
            return response()->json(['message' => 'Reto no encontrado'], 404);
        }
        if ($ur->Completado) {
            return response()->json(['message' => 'Este reto ya fue completado'], 422);
        }

        $ur->Completado = true;
        $ur->Completado_en = now();
        $ur->Puntos_obtenidos = $ur->reto->Puntos ?? 10;
        $ur->save();

        $servicio->otorgarPuntos($idUsuario, $ur->Puntos_obtenidos, 'Reto completado', 'reto', $ur->Id_usuario_reto);
        $racha = $servicio->actualizarRacha($idUsuario);
        $logros = $servicio->verificarLogros($idUsuario);

        return response()->json([
            'message' => "¡Completaste tu reto de hoy! +{$ur->Puntos_obtenidos} puntos.",
            'puntosGanados' => $ur->Puntos_obtenidos,
            'saldo' => $servicio->saldoPuntos($idUsuario),
            'racha' => $racha,
            'logrosDesbloqueados' => $logros,
        ]);
    }

    public function puntos(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $historial = Punto::where('Id_usuario', $idUsuario)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'saldo' => $servicio->saldoPuntos($idUsuario),
            'historial' => $historial,
        ]);
    }

    public function recompensas(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $recompensas = Recompensa::where('Activo', true)->get();
        $canjes = Canje::with('recompensa')->where('Id_usuario', $idUsuario)->get();
        $saldo = $servicio->saldoPuntos($idUsuario);

        return response()->json([
            'saldo' => $saldo,
            'recompensas' => $recompensas,
            'canjes' => $canjes,
        ]);
    }

    public function canjear(Request $request, $idUsuario)
    {
        $request->validate([
            'idRecompensa' => 'required|exists:recompensas,Id_recompensa',
        ]);

        $servicio = new GamificacionService;
        $recompensa = Recompensa::where('Id_recompensa', $request->idRecompensa)->where('Activo', true)->first();
        if (! $recompensa) {
            return response()->json(['message' => 'Recompensa no disponible'], 404);
        }

        $saldo = $servicio->saldoPuntos($idUsuario);
        if ($saldo < $recompensa->Costo_puntos) {
            return response()->json(['message' => 'No tienes puntos suficientes para esta recompensa'], 422);
        }

        if (! $recompensa->Repetible) {
            $ya = Canje::where('Id_usuario', $idUsuario)->where('Id_recompensa', $recompensa->Id_recompensa)->exists();
            if ($ya) {
                return response()->json(['message' => 'Ya canjeaste esta recompensa anteriormente'], 422);
            }
        }

        Canje::create([
            'Id_usuario' => $idUsuario,
            'Id_recompensa' => $recompensa->Id_recompensa,
            'Puntos_usados' => $recompensa->Costo_puntos,
            'Estado' => 'activo',
            'Fecha' => Carbon::today()->toDateString(),
        ]);

        $servicio->otorgarPuntos($idUsuario, -$recompensa->Costo_puntos, 'Canje de recompensa', 'canje', $recompensa->Id_recompensa);

        return response()->json([
            'message' => '¡Recompensa canjeada con éxito!',
            'saldo' => $servicio->saldoPuntos($idUsuario),
        ]);
    }

    public function logros(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $servicio->verificarLogros($idUsuario);
        $todos = Logro::all();
        $obtenidos = UsuarioLogro::where('Id_usuario', $idUsuario)->pluck('Id_logro')->toArray();

        return response()->json($todos->map(function ($l) use ($obtenidos) {
            return [
                'idLogro' => $l->Id_logro,
                'nombre' => $l->Nombre,
                'descripcion' => $l->Descripcion,
                'icono' => $l->Icono,
                'condicion' => $l->Condicion,
                'meta' => $l->Meta,
                'desbloqueado' => in_array($l->Id_logro, $obtenidos),
            ];
        })->values());
    }

    public function racha(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $racha = $servicio->asegurarRacha($idUsuario);

        return response()->json([
            'actual' => $racha->Racha_actual,
            'mejor' => $racha->Mejor_racha,
            'dias' => $racha->Dias_completados,
            'ultimaFecha' => $racha->Ultima_fecha,
        ]);
    }

    public function perfilIntegrado(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService;
        $racha = $servicio->asegurarRacha($idUsuario);

        return response()->json([
            'puntos' => $servicio->saldoPuntos($idUsuario),
            'retosCompletados' => UsuarioReto::where('Id_usuario', $idUsuario)->where('Completado', true)->count(),
            'racha' => $racha,
            'logros' => UsuarioLogro::with('logro')->where('Id_usuario', $idUsuario)->get()->map(function ($ul) {
                return ['nombre' => $ul->logro->Nombre, 'icono' => $ul->logro->Icono, 'descripcion' => $ul->logro->Descripcion];
            })->values(),
            'pedidos' => Pedido::where('Id_usuario', $idUsuario)->orderBy('created_at', 'desc')->limit(10)->get(),
            'canjes' => Canje::with('recompensa')->where('Id_usuario', $idUsuario)->get(),
        ]);
    }
}
