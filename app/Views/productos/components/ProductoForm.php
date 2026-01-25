<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0"><i class="bi bi-plus-circle"></i> Agregar Nuevo Producto</h5>
    </div>
    <div class="card-body p-4">
        <form action="/productos/guardar" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Laptop Pro" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles adicionales..."></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Precio ($)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 fw-bold">
                        <i class="bi bi-save"></i> Guardar Producto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>