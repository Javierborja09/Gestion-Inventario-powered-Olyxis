<h1>Gestión de Productos</h1>

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

<?php component('ProductoForm', ['categorias' => $categorias ?? []]); ?>
<?php component('ProductoTable', ['productos' => $productos ?? []]); ?>
<?php component('EditarProductoModal', ['categorias' => $categorias]); ?>