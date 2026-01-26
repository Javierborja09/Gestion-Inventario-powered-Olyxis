<?php

namespace App\Controllers;
use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\ProductoDAO;
use App\Models\VentaDAO;
use App\Middlewares\AuthMiddleware;

class VentasController extends Controller
{
    private ProductoDAO $productoDao;
    private VentaDAO $ventaDao;

    public function __construct()
    {
        $this->middleware(AuthMiddleware::class);
        $this->middleware(\App\Middlewares\SessionTimeoutMiddleware::class);
        $this->productoDao = new ProductoDAO();
        $this->ventaDao = new VentaDAO();
    }

    public function index(Request $request)
    {
        return $this->view('ventas/index', [
            'title'     => 'Módulo de Ventas',
            'productos' => $this->productoDao->getAll(),
            'ventas'    => $this->ventaDao->getAll()
        ], 'layouts/main');
    }

    public function store_lote(Request $request)
    {
        $items = $request->post('items');

        if (empty($items)) {
            $request->setFlash('error', '⚠️ La lista de venta está vacía.');
            return $this->redirect('/ventas');
        }

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

        if ($exito) {
            $request->setFlash('success', '✅ Venta procesada con éxito y stock actualizado.');
        } else {
            $request->setFlash('error', '❌ Error crítico al procesar la venta. Intente de nuevo.');
        }

        return $this->redirect('/ventas');
    }

    public function reportes(Request $request)
    {
        $inicio = $request->get('fecha_inicio');
        $fin = $request->get('fecha_fin');

        return $this->view('ventas/reportes', [
            'title'   => 'Reporte de Ventas',
            'resumen' => $this->ventaDao->getResumenGeneral($inicio, $fin),
            'ventas'  => $this->ventaDao->getAll($inicio, $fin)
        ], 'layouts/main');
    }
}
