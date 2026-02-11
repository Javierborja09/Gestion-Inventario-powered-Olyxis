<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Hash;
use Framework\Core\Request;
use App\DAOS\UsuarioDAO;
use App\Traits\Auditable;
use App\Middlewares\SessionTimeoutMiddleware;

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
    $motivo = $request->get('reason') === 'timeout' ? "Sesión expirada por inactividad" : "Cierre de sesión voluntario";

    if ($usuarioNombre) {
        $this->registrarKardex($request, 'SEGURIDAD', 'LOGOUT', $motivo, $usuarioNombre);
    }

    $request->session()->destroy();
    return $this->redirect('/');
}
public function sessionStatus(Request $request) {
    $session = $request->session();
    $timeout = \App\Middlewares\SessionTimeoutMiddleware::TIMEOUT; 
    
    $now = time();
    $lastActivity = $session->get('last_activity') ?? $now;
    $diff = $now - $lastActivity;
    $remaining = $timeout - $diff;

    header('Content-Type: application/json');
    if ($diff > $timeout) {
        http_response_code(401);
        echo json_encode(['status' => 'expired', 'remaining' => 0]);
    } else {
        echo json_encode(['remaining' => $remaining > 0 ? $remaining : 0]);
    }
    
    exit; 
}
}