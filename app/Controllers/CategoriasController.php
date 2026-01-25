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
        AuthMiddleware::handle(new Request());
        $this->categoriaDao = new CategoriaDAO();
    }

    public function index($request) {
        return $this->view('categorias/index', [
            'title' => 'Gestión de Categorías',
            'categorias' => $this->categoriaDao->getAll(),
            'flash_success' => $request->getFlash('success'),
            'flash_error' => $request->getFlash('error')
        ], 'layouts/main');
    }

    public function store($request) {
        $data = $request->post();
        if (empty($data['nombre'])) {
            $request->setFlash('error', 'El nombre es obligatorio.');
            return $request->redirect('/categorias');
        }

        if ($this->categoriaDao->create(new Categoria($data))) {
            $request->setFlash('success', 'Categoría creada con éxito.');
        } else {
            $request->setFlash('error', 'Error al crear la categoría.');
        }
        return $request->redirect('/categorias');
    }

    public function update($request) {
        $data = $request->post();
        $id = $data['id'] ?? null;

        if (!$id || empty($data['nombre'])) {
            $request->setFlash('error', 'Datos inválidos.');
            return $request->redirect('/categorias');
        }

        // Necesitarás agregar el método update a tu CategoriaDAO
        if ($this->categoriaDao->update(new Categoria($data))) {
            $request->setFlash('success', 'Categoría actualizada.');
        } else {
            $request->setFlash('error', 'No se pudo actualizar.');
        }
        return $request->redirect('/categorias');
    }

    public function destroy($request, $id) {
        if ($this->categoriaDao->delete($id)) {
            $request->setFlash('success', 'Categoría eliminada.');
        } else {
            $request->setFlash('error', 'No se puede eliminar (revisa si tiene productos asociados).');
        }
        return $request->redirect('/categorias');
    }
}