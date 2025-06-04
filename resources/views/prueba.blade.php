<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido - Modal Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap + jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="p-4">

<div class="container">
    <h3 class="mb-4">🧾 Registrar Pedido</h3>

    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
        ➕ Agregar Nuevo Cliente
    </button>

    <input type="text" id="buscarCliente" class="form-control mb-2" placeholder="Cliente seleccionado..." readonly>
    <input type="hidden" id="custnr">

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="formCrearCliente">
            <div class="modal-header">
              <h5 class="modal-title">Nuevo Cliente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="nuevoNombre" class="form-control mb-2" placeholder="Nombre completo" required>
                <input type="text" id="nuevoRUC" class="form-control mb-2" placeholder="RUC" required>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Guardar Cliente</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
      <div id="toastConfirmacion" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">✅ Cliente guardado</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function() {
    console.log('✅ JS cargado y listo');

    $('#formCrearCliente').on('submit', function(e) {
        e.preventDefault();

        const nombre = $('#nuevoNombre').val();
        const ruc = $('#nuevoRUC').val();

        // Simular creación con delay
        $.post('/clientes/crear-desde-pedido', {
    _token: '{{ csrf_token() }}',
    custname: nombre,
    ruc: ruc
})
.done(function (cliente) {
    console.log('✅ Cliente guardado:', cliente);

    $('#buscarCliente').val(cliente.custname);
    $('#custnr').val(cliente.custnr ?? '');
    $('#nuevoNombre, #nuevoRUC').val('');

    bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente')).hide();
    const toast = new bootstrap.Toast(document.getElementById('toastConfirmacion'));
    toast.show();
})
.fail(function (xhr) {
    console.error('❌ Error al guardar cliente:', xhr.status, xhr.responseText);
    alert('❌ No se pudo guardar el cliente');
});

    });
});
</script>

</body>
</html>
