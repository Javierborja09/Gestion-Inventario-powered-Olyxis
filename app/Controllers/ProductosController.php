<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\DAOS\ProductoDAO;
use App\DAOS\CategoriaDAO;
use App\DAOS\Entity\Producto;
use App\Traits\Auditable;
use App\Middlewares\SessionTimeoutMiddleware;
use App\Middlewares\AuthMiddleware;

class ProductosController extends Controller
{
    use Auditable;

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

        if ($this->productoDao->create(new Producto($data))) {
            $this->registrarKardex($request, 'PRODUCTOS', 'CREAR', "Producto registrado con stock: " . $data['stock'], $data['nombre']);
            
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

        if (!$id || !$this->categoriaDao->getById($data['categoria_id'])) {
            $request->setFlash('error', '❌ Datos no válidos.');
            return $this->redirect('/productos');
        }

        if ($this->productoDao->update(new Producto($data))) {
            $this->registrarKardex($request, 'PRODUCTOS', 'EDITAR', "Actualización de stock/datos a: " . $data['stock'], $data['nombre']);
            
            $request->setFlash('success', '✅ Producto actualizado correctamente!');
        } else {
            $request->setFlash('error', '❌ Error al actualizar.');
        }

        return $this->redirect('/productos');
    }

    public function destroy(Request $request, $id)
    {
        $producto = $this->productoDao->getById($id);

        if ($producto && $this->productoDao->delete($id)) {
            $this->registrarKardex($request, 'PRODUCTOS', 'ELIMINAR', "Eliminado definitivamente del sistema", $producto->nombre);
            
            $request->setFlash('success', 'Producto eliminado correctamente.');
        } else {
            $request->setFlash('error', 'No se pudo eliminar el producto.');
        }

        return $this->redirect('/productos');
    }
}