<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-dark fw-bold">Categorías Registradas</h5>
        <div class="input-group input-group-sm" style="max-width: 250px;">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="searchCat" class="form-control border-start-0 bg-light" placeholder="Buscar categoría...">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="catTable">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 80px;">#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($categorias as $c): ?>
                <tr class="cat-row">
                    <td class="ps-4 fw-bold text-muted"><?= $i++ ?></td>
                    <td class="fw-bold cat-name"><?= htmlspecialchars($c->nombre) ?></td>
                    <td class="text-muted small"><?= htmlspecialchars($c->descripcion ?? '---') ?></td>
                    <td class="text-end pe-4">
                        <button class="btn btn-outline-primary btn-sm me-1" onclick="openEditCat(<?= htmlspecialchars(json_encode($c)) ?>)">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="/categorias/eliminar/<?= $c->id ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchCat')?.addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.cat-row').forEach(row => {
        const name = row.querySelector('.cat-name').textContent.toLowerCase();
        row.style.display = name.includes(term) ? "" : "none";
    });
});
</script>