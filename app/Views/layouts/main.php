<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestión de Inventario' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 260px;
        }

        body {
            height: 100vh;
            margin: 0;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .mobile-header {
            display: none;
            background: #212529;
            color: white;
            padding: 10px 15px;
            z-index: 1100;
        }

        #wrapper {
            display: flex;
            width: 100%;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: #1a1d20;
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.3s ease;
            z-index: 1050;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            #sidebar {
                position: fixed;
                left: calc(-1 * var(--sidebar-width));
                height: 100vh;
            }

            #sidebar.active {
                left: 0;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: #141619;
            flex-shrink: 0;
        }

        #sidebar ul.components {
            padding: 15px 0;
            flex: 1;
            overflow-y: auto;
            list-style: none;
            margin: 0;
        }

        #sidebar ul li a {
            padding: 12px 25px;
            display: block;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: 0.2s;
        }

        #sidebar ul li a:hover,
        #sidebar ul li.active>a {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-left: 4px solid #0d6efd;
        }

        #content {
            flex: 1;
            overflow-y: auto;
            padding: 35px;
            background: #f8f9fa;
        }

        .user-panel {
            padding: 20px;
            background: #141619;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>

    <div id="overlay" class="sidebar-overlay"></div>

    <div class="mobile-header shadow-sm">
        <button type="button" id="sidebarCollapse" class="btn btn-dark border-secondary">
            <i class="bi bi-list fs-4"></i>
        </button>
        <span class="fw-bold">Mi Sistema</span>
        <div style="width: 40px;"></div>
    </div>

    <div id="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-white"><i class="bi bi-box-seam me-2 text-primary"></i>INVENTARIO</h5>
                <button class="btn btn-link text-white d-md-none p-0" id="closeSidebar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <ul class="components">
                <?php
                $currentPath = $request->getPath();
                ?>
                <?php if ($request->session()->has('user_id')): ?>
                    <li class="<?= ($currentPath == '/productos') ? 'active' : '' ?>">
                        <a href="/productos"><i class="bi bi-box me-2"></i> Inventario</a>
                    </li>
                    <li class="<?= ($currentPath == '/categorias') ? 'active' : '' ?>">
                        <a href="/categorias"><i class="bi bi-tags me-2"></i> Categorías</a>
                    </li>
                    <li class="<?= (strpos($currentPath, '/ventas') !== false && strpos($currentPath, 'reportes') === false) ? 'active' : '' ?>">
                        <a href="/ventas"><i class="bi bi-cart-check me-2"></i> Ventas</a>
                    </li>
                    <li class="<?= (strpos($currentPath, 'reportes') !== false) ? 'active' : '' ?>">
                        <a href="/ventas/reportes"><i class="bi bi-bar-chart-line me-2"></i> Reportes</a>
                    </li>
                <?php else: ?>
                    <li><a href="/"><i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>

            <?php if ($request->session()->has('user_id')): ?>
                <div class="user-panel">
                    <div class="d-flex align-items-center mb-3 text-light small">
                        <i class="bi bi-person-circle fs-5 me-2 text-info"></i>
                        <span class="fw-bold text-truncate"><?= htmlspecialchars($request->session()->get('user_name')) ?></span>
                    </div>
                    <a href="/logout" class="btn btn-outline-danger btn-sm w-100 py-2 fw-bold">
                        <i class="bi bi-power me-1"></i> Salir
                    </a>
                </div>
            <?php endif; ?>
        </nav>

        <main id="content">
            <?= $content ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const btnToggle = document.getElementById('sidebarCollapse');
        const btnClose = document.getElementById('closeSidebar');

        function toggleMenu() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        btnToggle?.addEventListener('click', toggleMenu);
        btnClose?.addEventListener('click', toggleMenu);
        overlay?.addEventListener('click', toggleMenu);

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    </script>
<?php if ($request->session()->has('user_id')): ?>
        <?php component('InactivityMonitor'); ?>
    <?php endif; ?>
</body>

</html>