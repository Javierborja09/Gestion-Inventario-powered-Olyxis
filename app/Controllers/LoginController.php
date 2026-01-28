<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Hash;
use Framework\Core\Request;
use App\Models\UsuarioDAO;
use App\Traits\Auditable;

class LoginController extends Controller
{
    use Auditable; 

    public function index(Request $request)
    {
        if ($request->session()->has('user_id')) {
            return $this->redirect('/productos');
        }
        return $this->view('login/index', [
            'title' => 'Iniciar Sesión'
        ], null);
    }

    public function authenticate(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');

        $userDao = new UsuarioDAO();
        $user = $userDao->findByUsername($username);

        if ($user && Hash::verify($password, $user->password)) {
            $request->session()->set('user_id', $user->id);
            $request->session()->set('user_name', $user->nombre);
            $this->registrarKardex($request, 'SEGURIDAD', 'LOGIN', "Inicio de sesión exitoso.", $user->nombre);

            $request->setFlash('success', 'Bienvenido de nuevo, ' . $user->nombre);

            return $this->redirect('/productos');
        }

        $request->setFlash('error', 'Usuario o contraseña incorrectos');
        return $this->redirect('/');
    }

    public function logout(Request $request)
    {
        $usuarioNombre = $request->session()->get('user_name');
        if ($usuarioNombre) {
            $this->registrarKardex($request, 'SEGURIDAD', 'LOGOUT', "Cierre de sesión voluntario", $usuarioNombre);
        }

        $request->session()->destroy();
        return $this->redirect('/?logout=success');
    }
}