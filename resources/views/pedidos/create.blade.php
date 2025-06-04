@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Pedido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">📦 Registrar Pedido</h2>

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

    <form action="{{ route('pedidos.store') }}" method="POST" id="formPedido">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                
                   <div class="position-relative">
                        <label for="custnr" class="form-label">Cliente</label>
                        <input type="text" id="buscarCliente" class="form-control" placeholder="Buscar cliente por nombre o RUC">
                        <input type="hidden" name="custnr" id="custnr">
                        <div id="sugerenciasCliente" class="list-group position-absolute w-100"></div>
                    </div>

            </div>
            <div class="col-md-6">
                <label for="obs" class="form-label">Observación</label>
                <input type="text" name="obs" class="form-control">
            </div>
        </div>

        <h5 class="mt-4">🛒 Agregar Productos</h5>

        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-3">
                <label class="form-label">Buscar código o descripción</label>
                <input type="text" class="form-control" id="buscarItem">
                <div id="sugerencias" class="list-group"></div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Código</label>
                <input type="text" id="codigo" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Descripción</label>
                <input type="text" id="descripcion" class="form-control" readonly>
            </div>
            <div class="col-md-1">
                <label class="form-label">Cantidad</label>
                <input type="number" id="cantidad" class="form-control" value="1" min="1">
            </div>
            <div class="col-md-1">
                <label class="form-label">Precio</label>
                <input type="number" id="precio" class="form-control" step="0.01" readonly>
            </div>
                  

            <div class="col-md-1">
                <button type="button" id="agregarItem" class="btn btn-primary w-100">+</button>
            </div>
        </div>

        <table class="table table-bordered" id="tablaItems">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                  
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
       
        <div class="text-end fs-4 mt-3">
             Total del pedido: <strong id="totalPedido">₲ 0</strong>
        </div>


        <input type="hidden" name="items_json" id="items_json">

      <div class="d-flex justify-content-between mt-4">
    <a href="{{ url('/') }}" class="btn btn-outline-secondary  btn-lg">❌ Cancelar</a>
    <button type="submit" class="btn btn-success">✅ Guardar </button>
</div>

    </form>
</div>

<script>
    let items = [];
    let costoActual = 0;
    
    // Setup global AJAX con token CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

     function actualizarTotalPedido() {
        let total = items.reduce((sum, item) => sum + (item.qty * item.precio), 0);
        document.getElementById('totalPedido').innerText = `₲ ${total.toLocaleString('es-PY')}`;
     }


    // Buscar producto
    $('#buscarItem').on('input', function () {
        let q = $(this).val();
        if (q.length < 2) return $('#sugerencias').empty();

        $.get('{{ route("buscar.item") }}', { q: q }, function (data) {
            let html = '';
            data.forEach(item => {
                html += `<a href="#" class="list-group-item list-group-item-action"
                         data-item="${item.item}"
                         data-descr="${item.descr}"
                         data-precio="${item.precio1}"
                         data-costo="${item.costo}">
                         ${item.item} - ${item.descr}
                     </a>`;
            });
            $('#sugerencias').html(html).show();
        });
    });

    // Selección desde sugerencias
    $('#sugerencias').on('click', 'a', function (e) {
        e.preventDefault();
        $('#codigo').val($(this).data('item'));
        $('#descripcion').val($(this).data('descr'));
        $('#precio').val($(this).data('precio'));
       // $('#costo').val($(this).data('costo'));
         costoActual = parseFloat($(this).data('costo')); // capturamos el costo SIN mostrarlo
         
         $('#sugerencias').empty();
    });

    // Agregar ítem a la tabla
    $('#agregarItem').on('click', function () {
        const item = $('#codigo').val();
        const descr = $('#descripcion').val();
        const qty = parseFloat($('#cantidad').val());
        const precio = parseFloat($('#precio').val());
        const costo = costoActual;
       
        

        if (!item || qty < 1) return alert('Seleccione un producto y cantidad válida.');

        const subtotal = qty * precio;

        items.push({ item, descr, qty, precio, costo });

        const fila = `
        <tr>
            <td>${item}</td>
            <td>${descr}</td>
            <td>${qty}</td>
           <td>₲ ${precio.toLocaleString('es-PY', { minimumFractionDigits: 0 })}</td>    
            <td>${subtotal.toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-danger eliminar">🗑</button></td>
        </tr>`;

        $('#tablaItems tbody').append(fila);
        actualizarTotalPedido();
        // Limpiar campos
        $('#codigo, #descripcion, #cantidad, #precio, #costo, #buscarItem').val('');
        $('#cantidad').val(1);
    });

    // Eliminar ítem
    $('#tablaItems').on('click', '.eliminar', function () {
        const row = $(this).closest('tr');
        const codigo = row.find('td:first').text();
        row.remove();
        items = items.filter(i => i.item !== codigo);
        actualizarTotalPedido();

    });

    // Preparar datos para enviar
    $('#formPedido').on('submit', function () {
        if (items.length === 0) {
            alert('Debe agregar al menos un producto.');
            return false;
        }

        $('<input>').attr({
            type: 'hidden',
            name: 'items',
            value: JSON.stringify(items)
        }).appendTo(this);

        return true;
    });
  
    $('#buscarCliente').on('input', function () {
    let q = $(this).val();
    if (q.length < 2) return $('#sugerenciasCliente').empty();

    $.get('/buscar-cliente', { q: q }, function (data) {
         console.log('Clientes encontrados:', data.length);
    let html = '';
    if (data.length > 0) {
        data.forEach(c => {
            html += `<a href="#" class="list-group-item list-group-item-action"
                         data-custnr="${c.custnr}"
                         data-nombre="${c.custname}">
                         ${c.custname} (${c.custnr})
                     </a>`;
        });
    } else {
        html = `<div class="list-group-item text-center text-muted">No encontrado</div>
                <a href="#" id="btnNuevoCliente" class="list-group-item list-group-item-action text-primary text-center">
                    ➕ Agregar nuevo cliente
                </a>`;
    }
    $('#sugerenciasCliente').html(html).show();
});

});

$('#sugerenciasCliente').on('click', 'a', function (e) {
    e.preventDefault();
    $('#buscarCliente').val($(this).data('nombre'));
    $('#custnr').val($(this).data('custnr'));
    $('#sugerenciasCliente').empty();
});

    $(document).on('click', '#btnNuevoCliente', function (e) {
    e.preventDefault();
    $('#nuevoNombre').val($('#buscarCliente').val());
    $('#nuevoRUC, #nuevoTelefono, #latitud, #longitud, #ubicacion').val('');
    const modal = new bootstrap.Modal(document.getElementById('modalNuevoCliente'));
    modal.show();
});

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
        alert('GPS no soportado.');
    }
}

$('#formCrearCliente').on('submit', function (e) {
    e.preventDefault();

    const datos = {
        _token: '{{ csrf_token() }}',
        custname: $('#nuevoNombre').val(),
        ruc: $('#nuevoRUC').val(),
        telef1: $('#nuevoTelefono').val(),
        latitud: $('#latitud').val(),
        longitud: $('#longitud').val()
    };

    console.log('🟢 Enviando cliente:', datos);

    $.post('/clientes/crear-desde-pedido', datos)
        .done(function (cliente) {
           
            $('#buscarCliente').val(cliente.custname);
            $('#custnr').val(cliente.custnr ?? '');
            $('#sugerenciasCliente').empty();
            bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente')).hide();
             // Mostrar toast
                const toast = new bootstrap.Toast(document.getElementById('toastClienteGuardado'));
                 toast.show();
        }).fail(function (xhr) {
            console.error('❌ Error al guardar cliente:', xhr.status, xhr.responseText);
            alert('❌ No se pudo guardar el cliente');
        });
});
         

</script>

<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCrearCliente">
        <div class="modal-header">
          <h5 class="modal-title">➕ Nuevo Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nuevoNombre" required>
            </div>
            <div class="mb-2">
                <label>RUC</label>
                <input type="text" class="form-control" id="nuevoRUC" required>
            </div>
            <div class="mb-2">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="nuevoTelefono">
            </div>
            <div class="mb-2">
                <label>Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" readonly>
                <input type="hidden" id="latitud">
                <input type="hidden" id="longitud">
                <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="obtenerUbicacion()">📍 Obtener ubicación</button>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- ✅ Contenedor del Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="toastClienteGuardado" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        ✅ Cliente guardado y seleccionado.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

</body>
</html>
@endsection
