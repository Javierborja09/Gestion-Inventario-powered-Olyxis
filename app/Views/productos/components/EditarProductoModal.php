<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Producto 
                    <span class="badge bg-white text-primary ms-2" id="visual_id"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditar" action="/productos/actualizar" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Producto</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <select name="categoria_id" id="edit_categoria_id" class="form-select">
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat->id ?>">
                                    <?= htmlspecialchars($cat->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Precio ($)</label>
                            <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Stock</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3" style="resize: none;"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(producto) {
    // ID para el servidor
    document.getElementById('edit_id').value = producto.id;
    // ID Visual para el usuario
    document.getElementById('visual_id').textContent = 'ID: #' + producto.id;
    
    document.getElementById('edit_nombre').value = producto.nombre;
    document.getElementById('edit_categoria_id').value = producto.categoria_id;
    document.getElementById('edit_precio').value = producto.precio;
    document.getElementById('edit_stock').value = producto.stock;
    document.getElementById('edit_descripcion').value = producto.descripcion || '';
    
    const editModal = new bootstrap.Modal(document.getElementById('modalEditar'));
    editModal.show();
}
</script>