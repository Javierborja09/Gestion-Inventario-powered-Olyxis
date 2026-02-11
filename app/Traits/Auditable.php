<?php

namespace App\Traits;

use App\DAOS\KardexDAO;
use Framework\Core\Request;

trait Auditable {
    /**
     * Registra cualquier acción en el historial universal
     */
    protected function registrarKardex(Request $request, string $modulo, string $accion, string $desc, ?string $ref = null) {
        $kardex = new KardexDAO();
        $usuario = $request->session()->get('user_name') ?? 'Sistema';
        
        return $kardex->registrar($modulo, $accion, $usuario, $desc, $ref);
    }
}