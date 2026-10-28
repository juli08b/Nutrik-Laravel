<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prependToGroup('v1', ForceJsonResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('v1/*') || $request->expectsJson(),
        );

        /*
         * Los errores de /v1 se devuelven como JSON limpio, sin el "trace"
         * de Laravel: la respuesta siempre es {"message": "..."}.
         * Los errores de validación conservan su campo "errors".
         */
        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('v1/*') || $e instanceof ValidationException) {
                return null;
            }

            if ($e instanceof AuthenticationException) {
                $status = 401;
            } elseif ($e instanceof AuthorizationException) {
                $status = 403;
            } elseif ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
            } elseif (str_contains($e::class, 'ModelNotFound')) {
                $status = 404;
            } else {
                $status = 500;
            }

            $mensajes = [
                400 => 'Petición incorrecta.',
                401 => 'No autenticado.',
                403 => 'Sin permisos para esta operación.',
                404 => 'Recurso no encontrado.',
                405 => 'Método no permitido para esta ruta.',
                422 => 'Los datos enviados no son válidos.',
                500 => 'Error interno del servidor.',
            ];

            return response()->json([
                'message' => $mensajes[$status] ?? 'Error en la petición.',
            ], $status);
        });
    })->create();
