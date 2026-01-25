<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestión de Inventario' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 250px; }
        
        body { 
            height: 100vh; 
            margin: 0;
            background: #f8f9fa; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; 
        }

        /* HEADER MÓVIL: Solo visible en pantallas pequeñas */
        .mobile-header {
            display: none;
            background: #212529;
            color: white;
            padding: 10px 15px;
            z-index: 1100;
        }

        #wrapper { display: flex; width: 100%; flex: 1; overflow: hidden; position: relative; }

        /* SIDEBAR PROFESIONAL */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: #212529;
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.3s ease;
            z-index: 1050;
        }

        /* Estilos específicos para Celulares */
        @media (max-width: 768px) {
            .mobile-header { display: flex; align-items: center; justify-content: space-between; }
            
            #sidebar {
                position: fixed; /* Flota sobre el contenido */
                left: calc(-1 * var(--sidebar-width));
                height: 100vh;
            }
            #sidebar.active { left: 0; shadow: 0 0 15px rgba(0,0,0,0.5); }
            
            /* Sombra oscura cuando el menú está abierto */
            .sidebar-overlay {
                display: none;
                position: fixed;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.active { display: block; }
        }

        #sidebar .sidebar-header { padding: 20px; background: #1a1d20; flex-shrink: 0; }
        
        #sidebar ul.components { 
            padding: 20px 0; 
            flex: 1; 
            overflow-y: auto; 
            list-style: none;
            margin: 0;
        }
        
        #sidebar ul li a { 
            padding: 12px 20px; 
            display: block; 
            color: rgba(255,255,255,0.7); 
            text-decoration: none; 
        }
        
        #sidebar ul li a:hover, #sidebar ul li.active > a { 
            color: #fff; 
            background: rgba(255,255,255,0.1); 
        }

        /* ÁREA DE CONTENIDO */
        #content { 
            flex: 1;
            overflow-y: auto; 
            padding: 30px;
            background: #f8f9fa;
        }

        .user-panel { 
            padding: 20px; 
            background: #1a1d20; 
            border-top: 1px solid rgba(255,255,255,0.1);
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
    <div style="width: 40px;"></div> </div>

<div id="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white"><i class="bi bi-box-seam me-2"></i>Gestion Inventario</h4>
            <button class="btn btn-link text-white d-md-none p-0" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <ul class="components">
            <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'categorias') !== false) ? 'active' : '' ?>">
                <a href="/categorias"><i class="bi bi-tags me-2"></i> Categorías</a>
            </li>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'productos') !== false) ? 'active' : '' ?>">
                    <a href="/productos"><i class="bi bi-box me-2"></i> Inventario</a>
                </li>
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'ventas') !== false && strpos($_SERVER['REQUEST_URI'], 'reportes') === false) ? 'active' : '' ?>">
                    <a href="/ventas"><i class="bi bi-cart-check me-2"></i> Ventas</a>
                </li>
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'ventas/reportes') !== false) ? 'active' : '' ?>">
                    <a href="/ventas/reportes"><i class="bi bi-bar-chart-line me-2"></i> Reportes</a>
                </li>
            <?php else: ?>
                <li><a href="/login"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
            <?php endif; ?>
        </ul>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-panel">
                <div class="d-flex align-items-center mb-3 text-info small">
                    <i class="bi bi-person-circle fs-5 me-2"></i>
                    <span class="fw-bold text-truncate"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </div>
                <a href="/logout" class="btn btn-danger btn-sm w-100 py-2 fw-bold">
                    <i class="bi bi-power me-1"></i> Cerrar Sesión
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
</body>
</html>