<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-dark fw-bold">
            <i class="bi bi-list-ul me-2"></i>Listado de Productos
        </h5>
        <div class="input-group input-group-sm" style="max-width: 250px;">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="searchInput" class="form-control border-start-0 bg-light" placeholder="Buscar producto...">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="productosTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">#</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr class="no-results">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No hay productos registrados actualmente.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $i = 1; // Contador para el índice visual
                        foreach ($productos as $p): 
                        ?>
                        <tr class="product-row">
                            <td class="ps-4 fw-bold text-muted"><?= $i++ ?></td>
                            <td>
                                <div class="fw-bold product-name"><?= htmlspecialchars($p->nombre) ?></div>
                                <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                    <?= htmlspecialchars($p->descripcion ?? 'Sin descripción') ?>
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark opacity-75 product-category">
                                    <?= htmlspecialchars($p->categoria_nombre ?? 'General') ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                $<?= number_format($p->precio, 2) ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $stockClass = $p->stock <= 5 ? 'bg-danger' : ($p->stock <= 15 ? 'bg-warning text-dark' : 'bg-secondary');
                                ?>
                                <span class="badge <?= $stockClass ?> rounded-pill">
                                    <?= $p->stock ?> unid.
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($p)) ?>)"
                                            title="Editar producto">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <form action="/productos/eliminar/<?= $p->id ?>" method="POST" class="d-inline" 
                                          onsubmit="return confirm('¿Seguro que deseas eliminar <?= htmlspecialchars($p->nombre) ?>?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    const emptyStateRow = document.querySelector('.no-results');

    rows.forEach(row => {
        const name = row.querySelector('.product-name').textContent.toLowerCase();
        const category = row.querySelector('.product-category').textContent.toLowerCase();
        if (term === "" || name.includes(term) || category.includes(term)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
    document.querySelectorAll('.no-results-search').forEach(el => el.remove());
    if (emptyStateRow && term !== "") {
        emptyStateRow.style.display = "none";
    } else if (emptyStateRow && term === "") {
        emptyStateRow.style.display = "";
    }
});
</script>