@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📋 Listado de Clientes</h2>

   <form method="GET" action="{{ route('clientes.index') }}" class="row align-items-end g-2 mb-4">
    <div class="col-md-4 col-sm-6">
        <input type="text" name="buscar" class="form-control" placeholder="🔍 Buscar por nombre o RUC..." value="{{ request('buscar') }}">
    </div>
    <div class="col-md-auto col-sm-3">
        <button class="btn btn-primary w-100">Buscar</button>
    </div>
    <div class="col-md-auto col-sm-3">
        <a href="{{ route('clientes.create') }}" class="btn btn-success w-100">➕ Nuevo Cliente</a>
    </div>
</form>


    <!-- Botón flotante solo para móvil -->
        <a href="{{ route('clientes.create') }}"
            class="btn btn-success rounded-circle position-fixed d-md-none"
             style="bottom: 20px; right: 20px; z-index: 9999; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
             +
        </a>

   


    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Teléfono</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->custname }}</td>
                    <td>{{ $cliente->ruc }}</td>
                    <td>{{ $cliente->telef1 }}</td>
                    <td>
                        @if($cliente->latitud && $cliente->longitud)
                            <a href="https://www.google.com/maps?q={{ $cliente->latitud }},{{ $cliente->longitud }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                📍 Ver mapa
                            </a>
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->nro) }}" class="btn btn-sm btn-warning">✏️ Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection