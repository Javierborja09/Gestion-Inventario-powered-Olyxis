<h1 class="mb-4">Historial de Kardex</h1>

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
        <h5 class="card-title mb-0"><i class="bi bi-filter me-2"></i>Filtros de Historial</h5>
    </div>
    <div class="card-body p-4">
        <form action="/kardex" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="<?= $request->get('fecha_inicio') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control" value="<?= $request->get('fecha_fin') ?>">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-search me-1"></i> Filtrar
                        </button>
                        <a href="/kardex" class="btn btn-outline-secondary w-100 fw-bold">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-dark fw-bold">Movimientos del Sistema</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 80px;">ID</th>
                    <th>Módulo</th>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Descripción</th>
                    <th>Referencia</th>
                    <th class="text-end pe-4">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($movimientos)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted italic">
                            No se encontraron registros en el rango seleccionado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($movimientos as $m): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $m['id'] ?></td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= $m['modulo'] ?></span>
                            </td>
                            <td>
                                <?php 
                                    $color = match ($m['accion']) {
                                        'LOGIN'    => 'text-success',
                                        'LOGOUT'   => 'text-warning',
                                        'CREAR'    => 'text-primary',
                                        'EDITAR'   => 'text-info',
                                        'ELIMINAR' => 'text-danger',
                                        default    => 'text-dark'
                                    };
                                ?>
                                <strong class="<?= $color ?>"><?= $m['accion'] ?></strong>
                            </td>
                            <td class="fw-bold"><?= htmlspecialchars($m['usuario']) ?></td>
                            <td class="text-muted small"><?= htmlspecialchars($m['descripcion']) ?></td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                    <?= htmlspecialchars($m['nombre_item'] ?? '---') ?>
                                </span>
                            </td>
                            <td class="text-end pe-4 text-muted small">
                                <?= date('d/m/Y H:i', strtotime($m['fecha'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>