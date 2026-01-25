<!-- Vista de producto -->
<h1>Gestión de Productos</h1>

<?php if (isset($flash_success)): ?>
    <?php component('Alert', ['type' => 'success', 'message' => $flash_success]); ?>
<?php endif; ?>

<?php if (isset($flash_error)): ?>
    <?php component('Alert', ['type' => 'error', 'message' => $flash_error]); ?>
<?php endif; ?>

<!-- Componente local: formulario -->
<?php component('ProductoForm', ['categorias' => $categorias ?? []]); ?>

<!-- Componente local: tabla -->
<?php component('ProductoTable', ['productos' => $productos ?? []]); ?>

<!-- Componente local: modal editar -->
<?php component('EditarProductoModal', ['categorias' => $categorias]); ?>