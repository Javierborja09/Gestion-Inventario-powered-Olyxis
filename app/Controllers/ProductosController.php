<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\ProductoDAO;
use App\Models\CategoriaDAO;
use App\Models\Entity\Producto;
use App\Middlewares\SessionTimeoutMiddleware;
use App\Middlewares\AuthMiddleware;

class ProductosController extends Controller
{
    private ProductoDAO $productoDao;
    private CategoriaDAO $categoriaDao;

    public function __construct()
    {
        $this->middleware(AuthMiddleware::class);
        $this->middleware(SessionTimeoutMiddleware::class);
        $this->productoDao = new ProductoDAO();
        $this->categoriaDao = new CategoriaDAO();
    }

    public function index(Request $request)
    {
        return $this->view('productos/index', [
            'title'      => 'Gestión de Productos',
            'productos'  => $this->productoDao->getAll(),
            'categorias' => $this->categoriaDao->getAll(),
            
        ], 'layouts/main');
    }

    public function store(Request $request)
    {
        $data = $request->post();
        if (!$this->categoriaDao->getById($data['categoria_id'])) {
            $request->setFlash('error', '❌ Error: La categoría seleccionada no existe.');
            return $this->redirect('/productos');
        }

        $nuevoProducto = new Producto($data);

        if ($this->productoDao->create($nuevoProducto)) {
            $request->setFlash('success', '¡Producto guardado correctamente!');
        } else {
            $request->setFlash('error', 'Error al guardar el producto.');
        }

        return $this->redirect('/productos');
    }

    public function update(Request $request)
    {
        $data = $request->post();
        $id = $data['id'] ?? null;

        if (!$id) {
            $request->setFlash('error', '❌ ID de producto no válido.');
            return $this->redirect('/productos');
        }

        if (!$this->categoriaDao->getById($data['categoria_id'])) {
            $request->setFlash('error', '❌ Error: La categoría seleccionada no es válida.');
            return $this->redirect('/productos');
        }

        $productoActualizado = new Producto($data);

        if ($this->productoDao->update($productoActualizado)) {
            $request->setFlash('success', '✅ Producto actualizado correctamente!');
        } else {
            $request->setFlash('error', '❌ Error al actualizar en la base de datos.');
        }

        return $this->redirect('/productos');
    }

    public function destroy(Request $request, $id)
    {
        if ($this->productoDao->delete($id)) {
            $request->setFlash('success', 'Producto eliminado correctamente.');
        } else {
            $request->setFlash('error', 'No se pudo eliminar el producto.');
        }

        return $this->redirect('/productos');
    }
}