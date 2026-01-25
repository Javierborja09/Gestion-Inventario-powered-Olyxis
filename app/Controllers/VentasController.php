<?php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\ProductoDAO;
use App\Models\VentaDAO;
use App\Middlewares\AuthMiddleware;

class VentasController extends Controller {
    private $productoDao;
    private $ventaDao;

    public function __construct() {
        AuthMiddleware::handle(new Request());
        $this->productoDao = new ProductoDAO();
        $this->ventaDao = new VentaDAO();
    }

    public function index($request) {
        return $this->view('ventas/index', [
            'title' => 'Módulo de Ventas',
            'productos' => $this->productoDao->getAll(),
            'ventas' => $this->ventaDao->getAll(),
            'flash_success' => $request->getFlash('success'),
            'flash_error' => $request->getFlash('error')
        ], 'layouts/main');
    }

    /**
     * Muestra el reporte con filtros de fecha
     */
    public function reportes($request) {
        // Capturar fechas de la URL (GET)
        $inicio = $request->get('fecha_inicio');
        $fin = $request->get('fecha_fin');

        return $this->view('ventas/reportes', [
            'title'   => 'Reporte de Ventas',
            'resumen' => $this->ventaDao->getResumenGeneral($inicio, $fin),
            'ventas'  => $this->ventaDao->getAll($inicio, $fin)
        ], 'layouts/main');
    }

    public function store_lote($request) {
        $items = $request->post('items');
        if (empty($items)) return $request->redirect('/ventas');

        $exito = true;
        foreach ($items as $item) {
            if (!$this->ventaDao->create([
                'producto_id' => $item['id'],
                'cantidad'    => $item['cantidad'],
                'precio'      => $item['precio']
            ])) {
                $exito = false;
                break;
            }
        }

        if ($exito) $request->setFlash('success', '✅ Venta procesada con éxito.');
        else $request->setFlash('error', '❌ Error al procesar uno o más productos.');

        return $request->redirect('/ventas');
    }
}