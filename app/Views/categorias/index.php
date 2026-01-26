<h1>Gestión de Categorías</h1>

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

<?php component('CategoriaForm'); ?>

<?php component('CategoriaTable', ['categorias' => $categorias ?? []]); ?>

<?php component('EditarCategoriaModal'); ?>