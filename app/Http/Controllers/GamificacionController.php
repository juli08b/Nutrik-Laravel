<?php

namespace App\Http\Controllers;

use App\Models\Canje;
use App\Models\Logro;
use App\Models\MovimientoPunto;
use App\Models\PerfilRacha;
use App\Models\Recompensa;
use App\Models\Reto;
use App\Models\UsuarioLogro;
use App\Models\UsuarioReto;
use App\Services\GamificacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GamificacionController extends Controller
{
    // Consulto el resumen general de gamificación (puntos, racha, retos, logros y recompensas)
    public function dashboard(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $puntos = $servicio->saldoPuntos($idUsuario);
        $racha = $servicio->obtenerRacha($idUsuario);
        $hoy = Carbon::today()->toDateString();

        $retosHoy = UsuarioReto::with('reto')
            ->where('id_usuario', $idUsuario)
            ->where('fecha', $hoy)
            ->get();

        $completados = $retosHoy->where('completado', true)->count();
        $pendientes = $retosHoy->where('completado', false)->count();

        $mensaje = $pendientes > 0
            ? "¡Estás a {$pendientes} reto(s) de completar tu meta de hoy!"
            : ($completados > 0
                ? '¡Muy bien! Ya completaste tus retos de hoy.'
                : 'Pequeños hábitos construyen grandes resultados.');

        $logros = UsuarioLogro::with('logro')
            ->where('id_usuario', $idUsuario)
            ->get();

        $recompensas = Recompensa::where('activo', true)->get();
        $retoHoy = $retosHoy->first();

        $payload = [
            'puntos' => $puntos,
            'racha'  => [
                'actual'           => $racha?->racha_actual ?? 0,
                'mejor'            => $racha?->mejor_racha ?? 0,
                'dias_completados' => $racha?->dias_completados ?? 0,
            ],
            'retosCompletados'   => UsuarioReto::where('id_usuario', $idUsuario)->where('completado', true)->count(),
            'completadosHoy'     => $completados,
            'totalHoy'           => $retosHoy->count(),
            'progresoPorcentaje' => $retosHoy->count() > 0 ? (int) round(($completados / $retosHoy->count()) * 100) : 0,
            'logros'             => $logros,
            'recompensas'        => $recompensas,
            'mensajeMotivador'   => $mensaje,
            'retoHoy'            => $retosHoy->map(function ($ur) {
                return [
                    'id_usuario_reto' => $ur->id_usuario_reto,
                    'id_reto'         => $ur->id_reto,
                    'titulo'          => $ur->reto?->titulo,
                    'descripcion'     => $ur->reto?->descripcion,
                    'categoria'       => $ur->reto?->categoria,
                    'icono'           => $ur->reto?->icono,
                    'puntos'          => $ur->reto?->puntos,
                    'completado'      => (bool) $ur->completado,
                    'fecha'           => $ur->fecha,
                ];
            })->values(),
            'primerRetoHoy' => $retoHoy ? [
                'id_usuario_reto' => $retoHoy->id_usuario_reto,
                'titulo'          => $retoHoy->reto?->titulo,
                'completado'      => (bool) $retoHoy->completado,
            ] : null,
        ];

        return response()->json(array_merge(['data' => $payload], $payload), 200);
    }

    // Listo y asigno automáticamente los retos diarios activos al usuario
    public function retos(Request $request, $idUsuario)
    {
        $hoy = Carbon::today()->toDateString();
        $retos = Reto::where('activo', true)->get();

        foreach ($retos as $reto) {
            UsuarioReto::firstOrCreate([
                'id_usuario' => $idUsuario,
                'id_reto'    => $reto->id_reto,
                'fecha'      => $hoy,
            ], [
                'completado'       => false,
                'puntos_obtenidos' => 0,
            ]);
        }

        $lista = UsuarioReto::with('reto')
            ->where('id_usuario', $idUsuario)
            ->where('fecha', $hoy)
            ->get()
            ->map(function ($ur) {
                return [
                    'id_usuario_reto'  => $ur->id_usuario_reto,
                    'id_reto'          => $ur->id_reto,
                    'titulo'           => $ur->reto?->titulo,
                    'descripcion'      => $ur->reto?->descripcion,
                    'categoria'        => $ur->reto?->categoria,
                    'icono'            => $ur->reto?->icono,
                    'puntos'           => $ur->reto?->puntos,
                    'completado'       => (bool) $ur->completado,
                    'puntos_obtenidos' => $ur->puntos_obtenidos,
                    'fecha'            => $ur->fecha,
                ];
            })->values();

        return response()->json(['data' => $lista], 200);
    }

    // Marco un reto como completado y otorgo los puntos correspondientes
    public function completarReto(Request $request, $idUsuario, $idUsuarioReto)
    {
        $servicio = new GamificacionService();
        $ur = UsuarioReto::with('reto')
            ->where('id_usuario_reto', $idUsuarioReto)
            ->where('id_usuario', $idUsuario)
            ->first();

        if (!$ur) {
            return response()->json(['message' => 'Reto no encontrado'], 404);
        }

        if ($ur->completado) {
            return response()->json(['message' => 'Este reto ya fue completado'], 422);
        }

        $ur->completado = true;
        $ur->completado_en = now();
        $ur->puntos_obtenidos = $ur->reto?->puntos ?? 10;
        $ur->save();

        $servicio->otorgarPuntos($idUsuario, $ur->puntos_obtenidos, 'Reto completado', 'Reto #' . $ur->id_usuario_reto);
        $racha = $servicio->registrarActividad($idUsuario);
        $logros = $servicio->verificarLogros($idUsuario);

        $payload = [
            'puntosGanados'       => $ur->puntos_obtenidos,
            'saldo'               => $servicio->saldoPuntos($idUsuario),
            'racha'               => $racha,
            'logrosDesbloqueados' => $logros,
        ];

        return response()->json(array_merge([
            'message' => "¡Completaste tu reto de hoy! (+{$ur->puntos_obtenidos} puntos)",
            'data'    => $payload,
        ], $payload), 200);
    }

    // Consulto el saldo y el historial de movimientos de puntos
    public function puntos(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $historial = MovimientoPunto::where('id_usuario', $idUsuario)
            ->orderBy('created_at', 'desc')
            ->get();

        $payload = [
            'saldo'     => $servicio->saldoPuntos($idUsuario),
            'historial' => $historial,
        ];

        return response()->json(array_merge(['data' => $payload], $payload), 200);
    }

    // Listo las recompensas activas y el historial de canjes del usuario
    public function recompensas(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $recompensas = Recompensa::where('activo', true)->get();
        $canjes = Canje::with('recompensa')
            ->where('id_usuario', $idUsuario)
            ->orderBy('created_at', 'desc')
            ->get();

        $payload = [
            'saldo'       => $servicio->saldoPuntos($idUsuario),
            'recompensas' => $recompensas,
            'canjes'      => $canjes,
        ];

        return response()->json(array_merge(['data' => $payload], $payload), 200);
    }

    // Canjeo una recompensa descontando los puntos del saldo del usuario
    public function canjear(Request $request, $idUsuario)
    {
        $request->validate([
            'id_recompensa' => 'required|exists:recompensas,id_recompensa',
        ]);

        $servicio = new GamificacionService();
        $recompensa = Recompensa::where('id_recompensa', $request->id_recompensa)
            ->where('activo', true)
            ->first();

        if (!$recompensa) {
            return response()->json(['message' => 'Recompensa no disponible'], 404);
        }

        $saldo = $servicio->saldoPuntos($idUsuario);
        if ($saldo < $recompensa->costo_puntos) {
            return response()->json(['message' => 'No tienes puntos suficientes para esta recompensa'], 422);
        }

        if (!$recompensa->repetible) {
            $ya = Canje::where('id_usuario', $idUsuario)
                ->where('id_recompensa', $recompensa->id_recompensa)
                ->exists();

            if ($ya) {
                return response()->json(['message' => 'Ya canjeaste esta recompensa anteriormente'], 422);
            }
        }

        $canje = Canje::create([
            'id_usuario'    => $idUsuario,
            'id_recompensa' => $recompensa->id_recompensa,
            'puntos_usados' => $recompensa->costo_puntos,
            'estado'        => 'activo',
            'fecha'         => Carbon::today()->toDateString(),
        ]);

        $servicio->otorgarPuntos($idUsuario, -$recompensa->costo_puntos, 'Canje de recompensa', 'Recompensa #' . $recompensa->id_recompensa);

        $payload = [
            'canje' => $canje,
            'saldo' => $servicio->saldoPuntos($idUsuario),
        ];

        return response()->json(array_merge([
            'message' => 'Recompensa canjeada correctamente',
            'data'    => $payload,
        ], $payload), 200);
    }

    // Listo todos los logros disponibles indicando cuáles ha desbloqueado el usuario
    public function logros(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $servicio->verificarLogros($idUsuario);

        $todos = Logro::all();
        $obtenidos = UsuarioLogro::where('id_usuario', $idUsuario)
            ->get()
            ->keyBy('id_logro');

        $lista = $todos->map(function ($l) use ($obtenidos) {
            $u = $obtenidos->get($l->id_logro);
            return [
                'id_logro'     => $l->id_logro,
                'nombre'       => $l->nombre,
                'descripcion'  => $l->descripcion,
                'icono'        => $l->icono,
                'tipo'         => $l->tipo,
                'condicion'    => $l->condicion,
                'meta'         => $l->meta,
                'desbloqueado' => $u !== null,
                'fecha'        => $u ? $u->desbloqueado_en : null,
            ];
        })->values();

        return response()->json(['data' => $lista], 200);
    }

    // Consulto la racha actual y la mejor racha del usuario
    public function racha(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $racha = $servicio->obtenerRacha($idUsuario);

        $payload = [
            'racha_actual'     => $racha?->racha_actual ?? 0,
            'mejor_racha'      => $racha?->mejor_racha ?? 0,
            'dias_completados' => $racha?->dias_completados ?? 0,
            'ultima_fecha'     => $racha?->ultima_fecha ?? null,
        ];

        return response()->json(array_merge(['data' => $payload], $payload), 200);
    }

    // Consulto el perfil integrado de gamificación del usuario
    public function perfilIntegrado(Request $request, $idUsuario)
    {
        $servicio = new GamificacionService();
        $racha = $servicio->obtenerRacha($idUsuario);
        $retosCompletados = UsuarioReto::where('id_usuario', $idUsuario)->where('completado', true)->count();
        $retosTotales = UsuarioReto::where('id_usuario', $idUsuario)->count();
        $logros = UsuarioLogro::with('logro')->where('id_usuario', $idUsuario)->get()->map(function ($ul) {
            return [
                'nombre'      => $ul->logro?->nombre,
                'icono'       => $ul->logro?->icono,
                'descripcion' => $ul->logro?->descripcion,
            ];
        })->values();

        $pedidos = Pedido::where('id_usuario', $idUsuario)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $canjes = Canje::with('recompensa')
            ->where('id_usuario', $idUsuario)
            ->get();

        $payload = [
            'puntos'           => $servicio->saldoPuntos($idUsuario),
            'racha'            => $racha?->racha_actual ?? 0,
            'mejorRacha'       => $racha?->mejor_racha ?? 0,
            'retosCompletados' => $retosCompletados,
            'retosTotales'     => $retosTotales,
            'logros'           => $logros,
            'pedidos'          => $pedidos,
            'canjes'           => $canjes,
        ];

        return response()->json(array_merge(['data' => $payload], $payload), 200);
    }
}