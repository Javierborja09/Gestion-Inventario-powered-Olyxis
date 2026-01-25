<?php
namespace App\Middlewares;

use Framework\Core\Request;

class AuthMiddleware {
    /**
     * Verifica la sesión del usuario.
     */
    public static function handle(Request $request) {
        if (!$request->session('user_id')) {
            $request->setFlash('error', 'Debes iniciar sesión para acceder.');
            $request->redirect('/');
        }
    }
}