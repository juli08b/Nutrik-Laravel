<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nutrik · @yield('title', 'Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f4; }
        .brand-dot { color: #198754; }
        .card-simple { border: 0; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Nutrik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navNutrik">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navNutrik">
                <ul class="navbar-nav me-auto">
                    @php
                        $secciones = [
                            'usuarios' => 'Usuarios',
                            'categorias' => 'Categorías',
                            'productos' => 'Productos',
                            'descuentos' => 'Descuentos',
                            'carrito' => 'Carrito',
                            'pedidos' => 'Pedidos',
                            'detalle-compras' => 'Detalle compras',
                        ];
                    @endphp
                    @foreach ($secciones as $ruta => $texto)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($ruta.'.*') ? 'active fw-semibold' : '' }}"
                               href="{{ route($ruta.'.index') }}">{{ $texto }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @include('includes.flash')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
