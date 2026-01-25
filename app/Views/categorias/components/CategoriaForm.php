<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title mb-0"><i class="bi bi-tag-fill me-2"></i>Nueva Categoría</h5>
    </div>
    <div class="card-body p-4">
        <form action="/categorias/guardar" method="POST">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Nombre</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Laptops" required>
                </div>
                <div class="col-md-7">
                    <label class="form-label fw-bold">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" placeholder="Opcional...">
                </div>
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Registrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>