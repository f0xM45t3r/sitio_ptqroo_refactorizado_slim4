<?php
use Slim\App;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use App\Middleware\TwigFlashMiddleware;


use Slim\Psr7\Request;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;



return function (App $app) {
    // Permite usar métodos PUT/DELETE en formularios HTML
    $app->add(MethodOverrideMiddleware::class);

    // Middleware de Twig
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    // Manejo de errores (opcionalmente puedes usar configuraciones más avanzadas)
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    // Personalizar el handler para errores 404
    $errorMiddleware->setErrorHandler(
        HttpNotFoundException::class,
        function (Request $request, Throwable $exception) use ($app) {
            $twig = $app->getContainer()->get('view');
            $response = $app->getResponseFactory()->createResponse();
            return $twig->render($response->withStatus(404), 'handler/404.twig');
        }
    );   

    // Aquí puedes agregar middleware personalizado como AuthMiddleware si aplica globalmente
    
    // Middleware para flash messages
    $app->add(TwigFlashMiddleware::class);
};
