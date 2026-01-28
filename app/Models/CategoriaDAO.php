<?php

namespace App\Models;

use Framework\Core\Database;
use App\Models\Entity\Categoria;

class CategoriaDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene todas las categorías
     */
    public function getAll(): array
    {
        $stmt = $this->db->call('sp_listar_categorias');
        $rows = $stmt->fetchAll();

        $categorias = [];
        foreach ($rows as $row) {
            $categorias[] = new Categoria($row);
        }

        return $categorias;
    }

    

    /**
     * Obtiene una categoría por su ID
     */
    public function getById($id): ?Categoria
    {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $row = $this->db->fetch($sql, [$id]);

        return $row ? new Categoria($row) : null;
    }

    /**
     * Inserta una nueva categoría
     */
    public function create(Categoria $categoria): bool
    {
        $data = [
            'nombre' => $categoria->nombre,
            'descripcion' => $categoria->descripcion
        ];
        return (bool) $this->db->insert('categorias', $data);
    }

    /**
     * Actualiza una categoría existente
     * Agregado para completar CategoriasController@update
     */
    public function update(Categoria $categoria): bool
    {
        $data = [
            'nombre' => $categoria->nombre,
            'descripcion' => $categoria->descripcion
        ];

        return (bool) $this->db->update('categorias', $data, "id = ?", [$categoria->id]);
    }

    /**
     * Elimina una categoría
     */
    public function delete($id): bool
    {
        return (bool) $this->db->delete('categorias', "id = ?", [$id]);
    }
}