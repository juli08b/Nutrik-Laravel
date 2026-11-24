<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Credenciales del administrador inicial
    |--------------------------------------------------------------------------
    |
    | Se leen desde el entorno para que ningún secreto quede en el código.
    | El seeder falla si ADMIN_EMAIL o ADMIN_PASSWORD no están definidos.
    |
    */
    'name' => env('ADMIN_NAME', 'Administrador Nutrik'),
    'email' => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),
];
