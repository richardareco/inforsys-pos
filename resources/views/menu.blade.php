 @extends('layouts.app')

@section('content')
 <title>Inforsys Pos</title>
<h2 class="text-center mb-4">Menú Principal</h2>

<div class="row row-cols-2 row-cols-md-3 g-4">
    <div class="col">
        <a href="{{ route('clientes.index') }}" class="btn btn-light w-100 p-4 shadow border text-center h-100">
            <div class="fs-1"><i class="bi bi-people-fill"></i></div>
            <div class="fw-bold mt-2">Clientes</div>
        </a>
    </div>
    <div class="col">
        <a href="{{ route('pedidos.create') }}" class="btn btn-light w-100 p-4 shadow border text-center h-100">
            <div class="fs-1"><i class="bi bi-cart-fill"></i></div>
            <div class="fw-bold mt-2">Hacer Pedido</div>
        </a>
    </div>
    <div class="col">
        <a href="{{ route('pedidos.index') }}" class="btn btn-light w-100 p-4 shadow border text-center h-100">
            <div class="fs-1"><i class="bi bi-card-checklist"></i></div>
            <div class="fw-bold mt-2">Pedidos Realizados</div>
        </a>
    </div>
    <div class="col">
        <a href="#" class="btn btn-light w-100 p-4 shadow border text-center h-100">
            <div class="fs-1"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="fw-bold mt-2">Dashboard</div>
        </a>
    </div>
    <div class="col">
        <a href="#" class="btn btn-light w-100 p-4 shadow border text-center h-100">
            <div class="fs-1"><i class="bi bi-gear-fill"></i></div>
            <div class="fw-bold mt-2">Configuración</div>
        </a>
    </div>
</div>
@endsection

