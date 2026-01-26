<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\CategoriaDAO;
use App\Models\Entity\Categoria;
use App\Middlewares\AuthMiddleware;

class CategoriasController extends Controller {
    private CategoriaDAO $categoriaDao;

    public function __construct() {
        $this->middleware(AuthMiddleware::class);
        $this->middleware(\App\Middlewares\SessionTimeoutMiddleware::class);
        $this->categoriaDao = new CategoriaDAO();
    }

    public function index(Request $request) {
        return $this->view('categorias/index', [
            'title' => 'Gestión de Categorías',
            'categorias' => $this->categoriaDao->getAll()
        ], 'layouts/main');
    }

    public function store(Request $request) {
        $data = $request->post();
        if (empty($data['nombre'])) {
            $request->setFlash('error', 'El nombre es obligatorio.');
            return $this->redirect('/categorias');
        }

        if ($this->categoriaDao->create(new Categoria($data))) {
            $request->setFlash('success', 'Categoría creada con éxito.');
        } else {
            $request->setFlash('error', 'Error al crear la categoría.');
        }
        return $this->redirect('/categorias');
    }

    public function update(Request $request) {
        $data = $request->post();
        $id = $data['id'] ?? null;

        if (!$id || empty($data['nombre'])) {
            $request->setFlash('error', 'Datos inválidos.');
            return $this->redirect('/categorias');
        }
        
        if ($this->categoriaDao->update(new Categoria($data))) {
            $request->setFlash('success', 'Categoría actualizada.');
        } else {
            $request->setFlash('error', 'No se pudo actualizar.');
        }
        return $this->redirect('/categorias');
    }

    public function destroy(Request $request, $id) {
        if ($this->categoriaDao->delete($id)) {
            $request->setFlash('success', 'Categoría eliminada.');
        } else {
            $request->setFlash('error', 'No se puede eliminar (revisa si tiene productos asociados).');
        }
        return $this->redirect('/categorias');
    }
}