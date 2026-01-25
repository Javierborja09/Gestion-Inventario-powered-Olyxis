<?php
namespace App\Models\Entity;

class Producto {
    public ?int $id;
    public int $categoria_id;
    public string $nombre;
    public ?string $descripcion;
    public float $precio;
    public int $stock;
    public ?string $categoria_nombre; // Para cuando hagamos JOINs

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->categoria_id = $data['categoria_id'] ?? 0;
        $this->nombre = $data['nombre'] ?? '';
        $this->descripcion = $data['descripcion'] ?? null;
        $this->precio = (float)($data['precio'] ?? 0.0);
        $this->stock = (int)($data['stock'] ?? 0);
        $this->categoria_nombre = $data['categoria_nombre'] ?? null;
    }
    public function toArray(): array {
        return [
            'categoria_id' => $this->categoria_id,
            'nombre'       => $this->nombre,
            'descripcion'  => $this->descripcion,
            'precio'       => $this->precio,
            'stock'        => $this->stock
        ];
    }
}