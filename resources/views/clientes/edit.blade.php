@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">✏️ Editar Cliente</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente->nro) }}" method="POST" id="formEditarCliente">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" class="form-control" name="custname" value="{{ $cliente->custname }}" required>
        </div>

        <div class="mb-3">
            <label>RUC</label>
            <input type="text" class="form-control" name="ruc" value="{{ $cliente->ruc }}">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" class="form-control" name="telef1" value="{{ $cliente->telef1 }}">
        </div>

        <div class="mb-3">
            <label>Ubicación</label>
            <input type="text" class="form-control mb-1" id="ubicacion" readonly>
            <input type="hidden" name="latitud" id="latitud" value="{{ $cliente->latitud }}">
            <input type="hidden" name="longitud" id="longitud" value="{{ $cliente->longitud }}">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="obtenerUbicacion()">📍 Obtener ubicación</button>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">← Volver</a>
            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
        </div>
    </form>
</div>

<script>
function obtenerUbicacion() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            $('#latitud').val(pos.coords.latitude);
            $('#longitud').val(pos.coords.longitude);
            $('#ubicacion').val(`Lat: ${pos.coords.latitude.toFixed(4)}, Lng: ${pos.coords.longitude.toFixed(4)}`);
        }, function () {
            alert('No se pudo obtener la ubicación.');
        });
    } else {
        alert('GPS no soportado en este navegador');
    }
}

// Mostrar ubicación actual
$(document).ready(function () {
    let lat = $('#latitud').val();
    let lng = $('#longitud').val();
    if (lat && lng) {
        $('#ubicacion').val(`Lat: ${parseFloat(lat).toFixed(4)}, Lng: ${parseFloat(lng).toFixed(4)}`);
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
