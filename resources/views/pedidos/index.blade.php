@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">📋 Listado de Pedidos</h2>
        <form method="GET" class="row row-cols-lg-auto g-2 mb-3">
    <div class="col">
        <label>Desde:</label>
       <input type="date" name="desde" value="{{ $desde ?? '' }}">
    </div>
    <div class="col">
        <label>Hasta:</label>
        <input type="date" name="hasta" value="{{ $hasta ?? '' }}">
    </div>
    <div class="col d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</form>


        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Nro Nota</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Vendedor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $pedido->invnr }}</td>
                        <td>{{ $pedido->cliente->custname ?? $pedido->custnr }}</td>

                        <td>₲ {{ number_format($pedido->total, 0, ',', '.') }}</td>
                        <td>{{ $pedido->pernr }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
@endsection
