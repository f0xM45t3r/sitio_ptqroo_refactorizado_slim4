<?php

// src/Handler/NotFoundHandler.php
namespace App\Handler;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Twig\Environment;

class NotFoundHandler
{
    private ResponseFactoryInterface $responseFactory;
    private Environment $twig;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        Environment $twig
    ) {
        $this->responseFactory = $responseFactory;
        $this->twig = $twig;
    }

    public function __invoke(
        ServerRequestInterface $request,
        HttpNotFoundException $exception
    ) {
        $response = $this->responseFactory->createResponse(404);
        $html = $this->twig->render('handler/404.twig', [
            'path' => $request->getUri()->getPath()
        ]);
        $response->getBody()->write($html);
        return $response;
    }
}
