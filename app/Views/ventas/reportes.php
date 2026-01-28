<h2 class="fw-bold mb-4 text-dark">Reporte General de Ventas</h2>

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

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title mb-0"><i class="bi bi-filter me-2"></i>Filtros de Reporte</h5>
    </div>
    <div class="card-body p-4">
        <form action="/ventas/reportes" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="<?= $_GET['fecha_inicio'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control" value="<?= $_GET['fecha_fin'] ?? '' ?>">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                    <a href="/ventas/reportes" class="btn btn-outline-secondary w-100 fw-bold">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body p-4 text-center">
                <h6 class="text-uppercase fw-bold opacity-75 small">Ventas Realizadas</h6>
                <h2 class="mb-0 fw-bold"><?= number_format($resumen['total_ventas']) ?></h2>
                <i class="bi bi-cart-check fs-1 opacity-25 position-absolute end-0 bottom-0 me-3 mb-2"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body p-4 text-center">
                <h6 class="text-uppercase fw-bold opacity-75 small">Unidades Vendidas</h6>
                <h2 class="mb-0 fw-bold"><?= number_format($resumen['items_vendidos']) ?></h2>
                <i class="bi bi-box-seam fs-1 opacity-25 position-absolute end-0 bottom-0 me-3 mb-2"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white h-100">
            <div class="card-body p-4 text-center">
                <h6 class="text-uppercase fw-bold opacity-75 small">Ingresos Totales</h6>
                <h2 class="mb-0 fw-bold">$<?= number_format($resumen['ingresos_totales'], 2) ?></h2>
                <i class="bi bi-currency-dollar fs-1 opacity-25 position-absolute end-0 bottom-0 me-3 mb-2"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-dark fw-bold"><i class="bi bi-list-stars me-2"></i>Historial Detallado</h5>
    </div>
    <div class="table-responsive" style="max-height: 500px;">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light sticky-top">
                <tr>
                    <th class="ps-4">Fecha</th>
                    <th>Producto</th>
                    <th class="text-center">Cant.</th>
                    <th>Precio Unit.</th>
                    <th class="text-end pe-4">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ventas)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted italic">
                            No se encontraron ventas en el rango seleccionado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td class="ps-4 text-muted small">
                                <?= date('d/m/Y H:i', strtotime($v['fecha'])) ?>
                            </td>
                            <td class="fw-bold text-dark">
                                <?= htmlspecialchars($v['producto_nombre']) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3"><?= $v['cantidad'] ?></span>
                            </td>
                            <td class="text-muted">
                                $<?= number_format($v['precio_unitario'], 2) ?>
                            </td>
                            <td class="text-end pe-4 fw-bold text-success">
                                $<?= number_format($v['total'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>