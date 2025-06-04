@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Registrar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#00C4CC">
    <link rel="apple-touch-icon" href="/icon-192.png">
        


</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">➕ Registrar Nuevo Cliente</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('clientes.store') }}" class="card p-4 shadow rounded">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label for="custname" class="form-label">🧑 Nombre del Cliente</label>
                <input type="text" name="custname" id="custname" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="ruc" class="form-label">🧾 RUC</label>
                <input type="text" name="ruc" id="ruc" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="telef1" class="form-label">📱 Teléfono</label>
                <input type="text" name="telef1" id="telef1" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="latitud" class="form-label">🌍 Latitud</label>
                <input type="text" name="latitud" id="latitud" class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label for="longitud" class="form-label">🌍 Longitud</label>
                <input type="text" name="longitud" id="longitud" class="form-control" readonly>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn btn-outline-primary" onclick="obtenerUbicacion()">📍 Registrar ubicación automáticamente</button>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    <button type="submit" class="btn btn-success">💾 Guardar Cliente</button>
</div>

    </form>
</div>

<script>
function obtenerUbicacion() {
    if (!navigator.geolocation) {
        alert('Geolocalización no soportada');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            alert(`✅ Latitud: ${pos.coords.latitude}, Longitud: ${pos.coords.longitude}`);
            document.getElementById('latitud').value = pos.coords.latitude;
            document.getElementById('longitud').value = pos.coords.longitude;
        },
        function (error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("❌ El usuario denegó el permiso de geolocalización.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("❌ Información de ubicación no disponible.");
                    break;
                case error.TIMEOUT:
                    alert("⏱️ Tiempo de espera agotado.");
                    break;
                default:
                    alert("❌ Error desconocido al obtener la ubicación.");
                    break;
            }
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
@endsection