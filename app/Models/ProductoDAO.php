<?php

namespace App\Models;

use Framework\Core\Database;
use App\Models\Entity\Producto;

class ProductoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene todos los productos usando un Stored Procedure
     */
    public function getAll(): array
    {
        $stmt = $this->db->call('sp_listar_productos');
        $rows = $stmt->fetchAll();

        $productos = [];
        foreach ($rows as $row) {
            $productos[] = new Producto($row);
        }

        return $productos;
    }

    /**
     * Obtiene un producto específico por su ID
     */
    public function getById($id): ?Producto
    {
        $sql = "SELECT * FROM productos WHERE id = ?";
        // Usamos fetch de tu clase Database que ya retorna el array asociativo
        $row = $this->db->fetch($sql, [$id]);

        return $row ? new Producto($row) : null;
    }

    public function update(Producto $producto): bool
    {
        $data = [
            'nombre'       => $producto->nombre,
            'categoria_id' => $producto->categoria_id,
            'precio'       => $producto->precio,
            'stock'        => $producto->stock,
            'descripcion'  => $producto->descripcion
        ];

        return (bool) $this->db->update('productos', $data, "id = ?", [$producto->id]);
    }

    /**
     * Guarda un objeto Producto en la base de datos
     */
    public function create(Producto $producto): bool
    {
        return (bool) $this->db->insert('productos', $producto->toArray());
    }

    /**
     * Elimina un producto por ID
     */
    public function delete($id): bool
    {
        return (bool) $this->db->delete('productos', "id = ?", [$id]);
    }
}
