<?php
namespace App\Models\Entity;

class Usuario {
    public ?int $id;
    public string $username;
    public string $password;
    public ?string $nombre;
    public ?string $created_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->nombre = $data['nombre'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }


    public function toArray(): array {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'nombre'   => $this->nombre
        ];
    }
}