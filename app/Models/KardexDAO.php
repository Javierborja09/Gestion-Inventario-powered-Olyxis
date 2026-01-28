<?php

namespace App\Models;

use Framework\Core\Database;

class KardexDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function registrar($modulo, $accion, $usuario, $descripcion, $referencia = null) {
        $data = [
            'modulo'            => strtoupper($modulo),
            'accion'            => strtoupper($accion),
            'usuario_nombre'    => $usuario,
            'descripcion'       => $descripcion,
            'referencia_nombre' => $referencia
        ];
        
        return (bool) $this->db->insert('kardex', $data);
    }

    /**
     * Implementación del buscador similar a VentaDAO
     */
    public function buscar($productoId = null, $inicio = null, $fin = null): array {
        // Normalizar filtros para el SP
        $productoId = !empty($productoId) ? $productoId : null;
        $inicio = !empty($inicio) ? $inicio : null;
        $fin = !empty($fin) ? $fin : null;

        // Llamada al nuevo Stored Procedure
        $stmt = $this->db->call('sp_buscar_kardex', [$productoId, $inicio, $fin]);
        return $stmt->fetchAll() ?: [];
    }

    public function getAll(): array {
        // Reutilizamos el buscador sin parámetros para traer todo
        return $this->buscar();
    }
}