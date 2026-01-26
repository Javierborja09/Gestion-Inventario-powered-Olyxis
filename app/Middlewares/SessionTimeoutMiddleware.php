<?php

namespace App\Middlewares;

use Framework\Core\Middleware;
use Framework\Core\Request;
use Framework\Core\Response;

class SessionTimeoutMiddleware implements Middleware {
    public function handle(Request $request, callable $next) {
        $session = $request->session();
        $now = time();
        $timeout = 300; 

        if ($session->has('user_id')) {
            $lastActivity = $session->get('last_activity');
            if ($lastActivity && ($now - $lastActivity > $timeout)) {
                $session->destroy();
                $session->setFlash('error', 'Tu sesión ha expirado por inactividad.');
                return new Response('', 302, ['Location' => '/']);
            }
            $session->set('last_activity', $now);
        }

        return $next($request);
    }
}