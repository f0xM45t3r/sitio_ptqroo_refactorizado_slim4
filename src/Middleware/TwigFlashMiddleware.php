<?php

namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Flash\Messages;
use Slim\Views\Twig;

class TwigFlashMiddleware implements MiddlewareInterface
{
    private Messages $flash;
    private Twig $view;

    public function __construct(Messages $flash, Twig $view)
    {
        $this->flash = $flash;
        $this->view = $view;
    }

    public function process(Request $request, Handler $handler): Response
    {
        // Pasar los mensajes flash como variable global a Twig
        $this->view->getEnvironment()->addGlobal('flash', $this->flash->getMessages());

        return $handler->handle($request);
    }
}
