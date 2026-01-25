<?php

namespace App\Models\Entity;

class Categoria
{
    public ?int $id;
    public string $nombre;
    public ?string $descripcion;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->nombre = $data['nombre'] ?? '';
        $this->descripcion = $data['descripcion'] ?? null;
    }
}