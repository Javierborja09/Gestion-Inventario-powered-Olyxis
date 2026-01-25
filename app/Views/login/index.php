<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <div class="display-6 text-primary mb-2">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h2 class="fw-bold h4">Mi Sistema</h2>
                        <p class="text-muted small">Ingresa tus credenciales para continuar</p>
                    </div>

                    <?php if (isset($flash_error)): ?>
                        <?php component('Alert', ['type' => 'error', 'message' => $flash_error]); ?>
                    <?php endif; ?>

                    <?php if (isset($flash_success)): ?>
                        <?php component('Alert', ['type' => 'success', 'message' => $flash_success]); ?>
                    <?php endif; ?>

                    <form action="/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Nombre de usuario" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                        </button>
                    </form>

                </div>
            </div>
            
            <div class="text-center mt-4 text-muted small">
                &copy; <?= date('Y') ?> Powered by Olyxis - Todos los derechos reservados
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>