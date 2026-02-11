<?php

namespace App\DAOS;

use Framework\Core\Database;
use App\DAOS\Entity\Usuario;

class UsuarioDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Busca un usuario por su nombre de usuario para el login
     */
    public function findByUsername(string $username): ?Usuario
    {
        $stmt = $this->db->call('sp_buscar_usuario', [$username]);
        $row = $stmt->fetch();
        return $row ? new Usuario($row) : null;
    }

    /**
     * Crea un nuevo usuario (útil para registro)
     */
    public function create(Usuario $usuario): bool
    {
        return (bool) $this->db->insert('usuarios', $usuario->toArray());
    }
}
