<h1>Gestión de Ventas</h1>
<div class="container-fluid">
    <?php 
    $success = $request->getFlash('success');
    $error = $request->getFlash('error');
    ?>

    <?php if ($success): ?>
        <?php component('Alert', ['type' => 'success', 'message' => $success]); ?>
    <?php endif; ?>

    <?php if ($error): ?>
        <?php component('Alert', ['type' => 'error', 'message' => $error]); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-search me-2"></i>Seleccionar Producto</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Producto</label>
                        <select id="select_producto" class="form-select">
                            <option value="">Seleccionar...</option>
                            <?php foreach ($productos as $p): ?>
                                <option value="<?= $p->id ?>" 
                                        data-precio="<?= $p->precio ?>" 
                                        data-stock="<?= $p->stock ?>"
                                        data-nombre="<?= htmlspecialchars($p->nombre) ?>">
                                    <?= htmlspecialchars($p->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="info_producto" class="p-3 bg-light rounded mb-3 d-none">
                        <div class="d-flex justify-content-between">
                            <span>Precio Unitario:</span>
                            <span class="fw-bold text-success" id="display_precio">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2">
                            <span>Stock Disponible:</span>
                            <span class="fw-bold" id="display_stock">0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cantidad a Vender</label>
                        <input type="number" id="input_cantidad" class="form-control" min="1" value="1">
                    </div>

                    <button type="button" id="btn_agregar" class="btn btn-outline-primary w-100 fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Agregar a la Lista
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form action="/ventas/guardar_lote" method="POST" id="form_venta">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detalle de la Venta</h5>
                        <h5 class="mb-0 fw-bold">Total: <span id="gran_total">$0.00</span></h5>
                    </div>
                    <div class="table-responsive" style="min-height: 250px;">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Producto</th>
                                    <th>Precio</th>
                                    <th>Cant.</th>
                                    <th>Subtotal</th>
                                    <th class="text-end pe-3">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="lista_venta">
                                <tr id="placeholder_vacio">
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-cart fs-1 d-block mb-2"></i> No hay productos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card-footer bg-white p-3">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <button type="submit" id="btn_vender" class="btn btn-success w-100 py-3 fw-bold shadow-sm d-none" onclick="return confirm('¿Confirmar la venta total?')">
                                    <i class="bi bi-check2-all me-1"></i> PROCESAR VENTA TOTAL
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="btn_comprobante" class="btn btn-outline-dark w-100 py-3 fw-bold d-none" onclick="generarTicket()">
                                    <i class="bi bi-printer me-1"></i> TICKET
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="ticket_print" class="d-none">
    <div style="width: 80mm; font-family: 'Courier New', monospace; font-size: 12px; padding: 10px;">
        <div style="text-align: center; margin-bottom: 10px;">
            <h3 style="margin: 0;">MI SISTEMA POS</h3>
            <p style="margin: 0;">Barranca, Perú</p>
            <p style="margin: 0;">Fecha: <span id="t_fecha"></span></p>
        </div>
        <p>--------------------------------</p>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left;">CANT</th>
                    <th style="text-align: left;">DESC</th>
                    <th style="text-align: right;">TOTAL</th>
                </tr>
            </thead>
            <tbody id="t_cuerpo"></tbody>
        </table>
        <p>--------------------------------</p>
        <div style="text-align: right; font-weight: bold; font-size: 14px;">
            TOTAL: <span id="t_total"></span>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</div>

<script>
let carrito = [];

// Mostrar info del producto
document.getElementById('select_producto').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const infoBox = document.getElementById('info_producto');
    if (option.value === "") {
        infoBox.classList.add('d-none');
        return;
    }
    infoBox.classList.remove('d-none');
    document.getElementById('display_precio').textContent = '$' + parseFloat(option.dataset.precio).toFixed(2);
    document.getElementById('display_stock').textContent = option.dataset.stock;
    document.getElementById('input_cantidad').value = 1;
});

// Agregar al carrito
document.getElementById('btn_agregar').addEventListener('click', function() {
    const select = document.getElementById('select_producto');
    const option = select.options[select.selectedIndex];
    const cantidad = parseInt(document.getElementById('input_cantidad').value);
    
    if (!option.value || cantidad <= 0) return;
    
    const yaAgregado = carrito.filter(i => i.id === option.value).reduce((a, b) => a + b.cantidad, 0);
    if ((cantidad + yaAgregado) > parseInt(option.dataset.stock)) {
        alert("⚠️ Stock insuficiente.");
        return;
    }

    carrito.push({
        id: option.value,
        nombre: option.dataset.nombre,
        precio: parseFloat(option.dataset.precio),
        cantidad: cantidad,
        subtotal: parseFloat(option.dataset.precio) * cantidad
    });

    renderizarCarrito();
});

// Renderizar tabla y botones
function renderizarCarrito() {
    const tbody = document.getElementById('lista_venta');
    const totalSpan = document.getElementById('gran_total');
    const btnVender = document.getElementById('btn_vender');
    const btnTicket = document.getElementById('btn_comprobante');
    
    tbody.innerHTML = '';
    let total = 0;

    if (carrito.length === 0) {
        tbody.innerHTML = `<tr id="placeholder_vacio"><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-cart fs-1 d-block mb-2"></i>No hay productos</td></tr>`;
        totalSpan.textContent = '$0.00';
        btnVender.classList.add('d-none');
        btnTicket.classList.add('d-none');
        return;
    }

    carrito.forEach((item, index) => {
        total += item.subtotal;
        tbody.innerHTML += `
            <tr>
                <td class="ps-3">${item.nombre} <input type="hidden" name="items[${index}][id]" value="${item.id}"></td>
                <td>$${item.precio.toFixed(2)} <input type="hidden" name="items[${index}][precio]" value="${item.precio}"></td>
                <td>${item.cantidad} <input type="hidden" name="items[${index}][cantidad]" value="${item.cantidad}"></td>
                <td class="fw-bold text-primary">$${item.subtotal.toFixed(2)}</td>
                <td class="text-end pe-3"><button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminar(${index})"><i class="bi bi-trash"></i></button></td>
            </tr>`;
    });

    totalSpan.textContent = '$' + total.toFixed(2);
    btnVender.classList.remove('d-none');
    btnTicket.classList.remove('d-none');
}

function eliminar(index) {
    carrito.splice(index, 1);
    renderizarCarrito();
}

function generarTicket() {
    const tFecha = document.getElementById('t_fecha');
    const tCuerpo = document.getElementById('t_cuerpo');
    const tTotal = document.getElementById('t_total');

    tFecha.textContent = new Date().toLocaleString();
    tCuerpo.innerHTML = '';
    let totalVenta = 0;

    carrito.forEach(item => {
        totalVenta += item.subtotal;
        tCuerpo.innerHTML += `
            <tr>
                <td>${item.cantidad}</td>
                <td>${item.nombre.substring(0, 15)}</td>
                <td style="text-align: right;">$${item.subtotal.toFixed(2)}</td>
            </tr>`;
    });
    tTotal.textContent = '$' + totalVenta.toFixed(2);

    const ventanaP = window.open('', '_blank');
    ventanaP.document.write('<html><head><title>Ticket</title></head><body>' + document.getElementById('ticket_print').innerHTML + '</body></html>');
    ventanaP.document.close();
    ventanaP.print();
    ventanaP.close();
}
</script>