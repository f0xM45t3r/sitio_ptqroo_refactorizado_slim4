<?php
namespace App\Middleware;

use Delight\Auth\Auth;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AuthMiddleware
{
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Handler $handler): Response
    {
        if (!$this->auth->isLoggedIn()) {
            // Usuario no autenticado
            $response = new \Slim\Psr7\Response();
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        // Usuario autenticado, continuar
        return $handler->handle($request);
    }
}