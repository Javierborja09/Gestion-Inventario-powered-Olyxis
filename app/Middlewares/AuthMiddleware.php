<?php

namespace App\Middlewares;

use Framework\Core\Middleware;
use Framework\Core\Request;
use Framework\Core\Response;

class AuthMiddleware implements Middleware {

    public function handle(Request $request, callable $next) {
        if (!$request->session()->get('user_id')) {
            $request->setFlash('error', 'Debes iniciar sesión para acceder.');
            return new Response('', 302, ['Location' => '/']);
        }
        return $next($request);
    }
}