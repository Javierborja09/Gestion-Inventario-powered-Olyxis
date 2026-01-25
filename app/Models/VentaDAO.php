<?php
namespace App\Models;

use Framework\Core\Database;

class VentaDAO
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene el listado de ventas (Detalle) con filtro opcional
     */
    public function getAll($inicio = null, $fin = null): array {
        // Convertimos strings vacíos a null para que el SP funcione correctamente
        $inicio = !empty($inicio) ? $inicio : null;
        $fin = !empty($fin) ? $fin : null;

        $stmt = $this->db->call('sp_listar_ventas_filtrado', [$inicio, $fin]);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Obtiene los totales (KPIs) con filtro opcional
     */
    public function getResumenGeneral($inicio = null, $fin = null): array {
        $inicio = !empty($inicio) ? $inicio : null;
        $fin = !empty($fin) ? $fin : null;

        $stmt = $this->db->call('sp_resumen_ventas_filtrado', [$inicio, $fin]);
        $row = $stmt->fetch();
        
        return [
            'total_ventas'     => $row['total_ventas'] ?? 0,
            'items_vendidos'   => $row['items_vendidos'] ?? 0,
            'ingresos_totales' => $row['ingresos_totales'] ?? 0
        ];
    }

    public function create(array $data): bool {
        try {
            $this->db->call('sp_registrar_venta', [
                $data['producto_id'],
                $data['cantidad'],
                $data['precio']
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error en Venta: " . $e->getMessage());
            return false;
        }
    }
}