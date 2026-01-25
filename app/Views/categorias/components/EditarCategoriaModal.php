<div class="modal fade" id="modalEditCat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar <span id="visual_cat_id"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/categorias/actualizar" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit_cat_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" name="nombre" id="edit_cat_nombre" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" id="edit_cat_desc" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditCat(cat) {
    document.getElementById('edit_cat_id').value = cat.id;
    document.getElementById('visual_cat_id').textContent = '#' + cat.id;
    document.getElementById('edit_cat_nombre').value = cat.nombre;
    document.getElementById('edit_cat_desc').value = cat.descripcion || '';
    new bootstrap.Modal(document.getElementById('modalEditCat')).show();
}
</script>