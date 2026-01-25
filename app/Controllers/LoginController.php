<?php

namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Hash;
use App\Models\UsuarioDAO; // Necesitarás crear este DAO

class LoginController extends Controller
{

    public function index($request)
    {
        if (isset($_SESSION['user_id'])) {
            return $request->redirect('/productos');
        }

        return $this->view('login/index', [
            'title' => 'Iniciar Sesión',
            'flash_error' => $request->getFlash('error'),
            'flash_success' => $request->getFlash('success')
        ], null);
    }

    public function authenticate($request)
    {
        $username = $request->post('username');
        $password = $request->post('password');

        // Aquí usarías tu DAO para buscar al usuario
        $userDao = new UsuarioDAO();
        $user = $userDao->findByUsername($username);

        if ($user && Hash::verify($password, $user->password)) {
            // Iniciar sesión
            $request->session('user_id', $user->id);
            $request->session('user_name', $user->nombre);
            $request->setFlash('success', 'Bienvenido de nuevo, ' . $user->nombre);
            return $request->redirect('/productos');
        }

        $request->setFlash('error', 'Usuario o contraseña incorrectos');
        return $request->redirect('/');
    }

    public function logout($request)
    {
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        header("Location: /?logout=success");
        exit;
    }
}
