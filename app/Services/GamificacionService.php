<?php

namespace App\Services;

use App\Models\Logro;
use App\Models\Pedido;
use App\Models\Punto;
use App\Models\UsuarioLogro;
use App\Models\UsuarioRacha;
use App\Models\UsuarioReto;
use Carbon\Carbon;

class GamificacionService
{
    public function asegurarRacha(int $idUsuario): UsuarioRacha
    {
        return UsuarioRacha::firstOrCreate(
            ['Id_usuario' => $idUsuario],
            ['Racha_actual' => 0, 'Mejor_racha' => 0, 'Dias_completados' => 0]
        );
    }

    public function saldoPuntos(int $idUsuario): int
    {
        $suma = Punto::where('Id_usuario', $idUsuario)->sum('Cantidad');

        return (int) $suma;
    }

    public function otorgarPuntos(int $idUsuario, int $cantidad, string $motivo, string $origen, ?string $referencia = null): Punto
    {
        return Punto::create([
            'Id_usuario' => $idUsuario,
            'Cantidad' => $cantidad,
            'Motivo' => $motivo,
            'Origen' => $origen,
            'Referencia' => $referencia,
        ]);
    }

    public function actualizarRacha(int $idUsuario): array
    {
        $racha = $this->asegurarRacha($idUsuario);
        $hoy = Carbon::today();
        $ultima = $racha->Ultima_fecha ? Carbon::parse($racha->Ultima_fecha) : null;

        if ($ultima && $ultima->equalTo($hoy)) {
            $racha->refresh();

            return ['actual' => $racha->Racha_actual, 'mejor' => $racha->Mejor_racha, 'dias' => $racha->Dias_completados, 'mensaje' => 'Ya sumaste actividad hoy.'];
        }

        if ($ultima && $ultima->diffInDays($hoy) === 1) {
            $racha->Racha_actual = ($racha->Racha_actual + 1);
        } else {
            $racha->Racha_actual = 1;
        }

        $racha->Dias_completados = ($racha->Dias_completados + 1);
        if ($racha->Racha_actual > $racha->Mejor_racha) {
            $racha->Mejor_racha = $racha->Racha_actual;
        }
        $racha->Ultima_fecha = $hoy->toDateString();
        $racha->save();

        $mensaje = match ($racha->Racha_actual) {
            1 => '¡Buen inicio! Tu racha acaba de comenzar 🔥',
            7 => '¡Una semana construyendo buenos hábitos! 🔥',
            14 => 'Dos semanas de constancia. ¡Imparable! 💚',
            30 => 'Un mes de hábitos. ¡Felicitaciones! 🎉',
            default => "🔥 Llevas {$racha->Racha_actual} días construyendo buenos hábitos.",
        };

        return ['actual' => $racha->Racha_actual, 'mejor' => $racha->Mejor_racha, 'dias' => $racha->Dias_completados, 'mensaje' => $mensaje];
    }

    public function verificarLogros(int $idUsuario): array
    {
        $desbloqueados = [];
        $logros = Logro::all();
        $completados = UsuarioReto::where('Id_usuario', $idUsuario)->where('Completado', true)->count();
        $primeraCompra = Pedido::where('Id_usuario', $idUsuario)->count();
        $racha = $this->asegurarRacha($idUsuario);

        foreach ($logros as $logro) {
            $yaTiene = UsuarioLogro::where('Id_usuario', $idUsuario)->where('Id_logro', $logro->Id_logro)->exists();
            if ($yaTiene) {
                continue;
            }

            $cumple = false;
            if ($logro->Condicion === 'retos_completados' && $completados >= $logro->Meta) {
                $cumple = true;
            }
            if ($logro->Condicion === 'primer_reto' && $completados >= 1) {
                $cumple = true;
            }
            if ($logro->Condicion === 'racha_dias' && $racha->Racha_actual >= $logro->Meta) {
                $cumple = true;
            }
            if ($logro->Condicion === 'primera_compra' && $primeraCompra >= 1) {
                $cumple = true;
            }

            if ($cumple) {
                UsuarioLogro::create(['Id_usuario' => $idUsuario, 'Id_logro' => $logro->Id_logro]);
                $desbloqueados[] = $logro;
            }
        }

        return $desbloqueados;
    }
}
