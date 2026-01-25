<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\ProductoDAO;
use App\Models\CategoriaDAO;
use App\Models\Entity\Producto;
use App\Middlewares\AuthMiddleware;

class ProductosController extends Controller
{
    private ProductoDAO $productoDao;
    private CategoriaDAO $categoriaDao;

    public function __construct()
    {
        AuthMiddleware::handle(new Request());
        $this->productoDao = new ProductoDAO();
        $this->categoriaDao = new CategoriaDAO();
    }

    public function index($request)
    {
        return $this->view('productos/index', [
            'title'         => 'Gestión de Productos',
            'productos'     => $this->productoDao->getAll(),
            'categorias'    => $this->categoriaDao->getAll(),
            'flash_success' => $request->getFlash('success'),
            'flash_error'   => $request->getFlash('error')
        ], 'layouts/main');
    }

    public function store($request)
    {
        $data = $request->post();
        if (!$this->categoriaDao->getById($data['categoria_id'])) {
            $request->setFlash('error', '❌ Error: La categoría seleccionada no existe.');
            return $request->redirect('/productos');
        }

        $nuevoProducto = new Producto($data);

        if ($this->productoDao->create($nuevoProducto)) {
            $request->setFlash('success', '¡Producto guardado correctamente!');
        } else {
            $request->setFlash('error', 'Error al guardar el producto.');
        }

        return $request->redirect('/productos');
    }

    public function update($request)
    {
        $data = $request->post();
        $id = $data['id'] ?? null;

        if (!$id) {
            $request->setFlash('error', '❌ ID de producto no válido.');
            return $request->redirect('/productos');
        }
        if (!$this->categoriaDao->getById($data['categoria_id'])) {
            $request->setFlash('error', '❌ Error: La categoría seleccionada no es válida.');
            return $request->redirect('/productos');
        }

        $productoActualizado = new Producto($data);

        if ($this->productoDao->update($productoActualizado)) {
            $request->setFlash('success', '✅ Producto actualizado correctamente!');
        } else {
            $request->setFlash('error', '❌ Error al actualizar en la base de datos.');
        }

        return $request->redirect('/productos');
    }

    public function destroy($request, $id)
    {
        if ($this->productoDao->delete($id)) {
            $request->setFlash('success', 'Producto eliminado correctamente.');
        } else {
            $request->setFlash('error', 'No se pudo eliminar el producto.');
        }

        return $request->redirect('/productos');
    }
}