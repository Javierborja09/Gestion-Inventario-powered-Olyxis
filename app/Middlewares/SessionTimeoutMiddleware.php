<?php

namespace App\Middlewares;

use Framework\Core\Middleware;
use Framework\Core\Request;
use Framework\Core\Response;

class SessionTimeoutMiddleware implements Middleware {
    public const TIMEOUT = 300;

 public function handle(Request $request, callable $next) {
    $session = $request->session();
    $timeout = self::TIMEOUT;

    if ($session->has('user_id')) {
        $now = time();
        $lastActivity = $session->get('last_activity') ?? $now;
        $diff = $now - $lastActivity;

        if ($request->get('reset')) {
            $session->set('last_activity', $now);
        }
        
        if ($diff > $timeout && !$request->isAjax() && $request->getPath() !== '/logout') {
            return new Response('', 302, ['Location' => '/logout?reason=timeout']);
        }
    }

    return $next($request);
}
}