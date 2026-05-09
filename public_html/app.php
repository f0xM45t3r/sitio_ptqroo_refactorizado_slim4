<?php
use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Iniciar sesión para flash messages y autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear el contenedor de dependencias con PHP-DI
$container = new Container();

// Crear la aplicación
AppFactory::setContainer($container);
$app = AppFactory::create();

// Compartir la instancia de $app en el contenedor
$container->set('app', $app);

// Registrar dependencias
$dependencies = require __DIR__ . '/../src/Dependencies.php';
$dependencies($container);

// Registrar middleware
$middleware = require __DIR__ . '/../src/Middleware.php';
$middleware($app);

// Registrar rutas
$routes = require __DIR__ . '/../src/Routes.php';
$routes($app);

// Ejecutar la aplicación
$app->run();
