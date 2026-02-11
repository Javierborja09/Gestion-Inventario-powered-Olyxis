<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\DAOS\KardexDAO;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\SessionTimeoutMiddleware;

class KardexController extends Controller
{
    private KardexDAO $kardexDao;

    public function __construct()
    {
        $this->middleware(AuthMiddleware::class);
        $this->middleware(SessionTimeoutMiddleware::class);
        $this->kardexDao = new KardexDAO();
    }

    public function index(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin    = $request->get('fecha_fin');

        $movimientos = $this->kardexDao->buscar(null, $fechaInicio, $fechaFin);

        return $this->view('kardex/index', [
            'title'       => 'Historial de Kardex',
            'movimientos' => $movimientos,
            'request'     => $request
        ], 'layouts/main');
    }
}