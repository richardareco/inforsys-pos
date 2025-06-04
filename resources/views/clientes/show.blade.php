<!DOCTYPE html>
<html>
<head>
    <title>Ver Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">👤 Detalles del Cliente</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $cliente->custname }}</h5>
            <p class="card-text"><strong>RUC:</strong> {{ $cliente->ruc }}</p>
            <p class="card-text"><strong>Teléfono:</strong> {{ $cliente->telef1 }}</p>
            <p class="card-text"><strong>Latitud:</strong> {{ $cliente->latitud }}</p>
            <p class="card-text"><strong>Longitud:</strong> {{ $cliente->longitud }}</p>

            @if($cliente->latitud && $cliente->longitud)
                <a href="https://www.google.com/maps/search/?api=1&query={{ $cliente->latitud }},{{ $cliente->longitud }}"
                   target="_blank" class="btn btn-outline-primary">
                    📍 Ver ubicación en Google Maps
                </a>
            @else
                <p class="text-muted">Ubicación no registrada.</p>
            @endif

            <div class="mt-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">🔙 Volver</a>
                <a href="{{ route('clientes.edit', $cliente->nro) }}" class="btn btn-warning">✏️ Editar</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
