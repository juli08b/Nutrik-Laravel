<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URL base de la API de Nutrik
    |--------------------------------------------------------------------------
    | Los controladores web (capa cliente) consumen esta API con la fachada
    | Http::. Se toma de URL_SERVER_API en el .env.
    */
    'api_url' => env('URL_SERVER_API', 'http://127.0.0.1:8000/api'),
];
