<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inforsys POS</title>

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#00C4CC">
    <link rel="apple-touch-icon" href="/icon-192.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #00C4CC;">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ url('/') }}">Inforsys Pos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('clientes.index') }}" class="nav-link">👥 Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pedidos.create') }}" class="nav-link">🧾 Nuevo Pedido</a>
                    </li>
                    <!-- Puedes agregar más enlaces aquí -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido dinámico -->
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
      .then(() => console.log('✔️ Service worker registrado'))
      .catch(error => console.error('❌ Error al registrar service worker', error));
  }
</script>


</body>
</html>
