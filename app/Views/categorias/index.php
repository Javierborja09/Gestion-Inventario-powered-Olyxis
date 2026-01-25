<div class="container py-4">
    <h2 class="mb-4 fw-bold">Gestión de Categorías</h2>

    <?php if (isset($flash_success)): ?>
        <?php component('Alert', ['type' => 'success', 'message' => $flash_success]); ?>
    <?php endif; ?>

    <?php if (isset($flash_error)): ?>
        <?php component('Alert', ['type' => 'error', 'message' => $flash_error]); ?>
    <?php endif; ?>

    <?php component('CategoriaForm'); ?>

    <?php component('CategoriaTable', ['categorias' => $categorias]); ?>

    <?php component('EditarCategoriaModal'); ?>
</div>