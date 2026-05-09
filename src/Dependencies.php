<?php
use Slim\Views\Twig;
use Twig\TwigFilter;
use Twig\Loader\FilesystemLoader;

//use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Para funcion del paginador 
use Illuminate\Pagination\Paginator;

use Psr\Container\ContainerInterface;

use App\Middleware\TwigFlashMiddleware;
use Slim\Flash\Messages;
use Delight\Auth\Auth;


return function($container) {
    $container->set('db', function() {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
			'port'      => $_ENV['DB_PORT'] ?? 3306,
            'database'  => $_ENV['DB_NAME'],
            'username'  => $_ENV['DB_USER'],
            'password'  => $_ENV['DB_PASS'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);
        //$capsule->setEventDispatcher(new Dispatcher());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
		
		return $capsule; // ¡Falta esta línea crítica!
    });
	
	$container->set(Auth::class, function ($container) {
        $db = $container->get('db');
        return new Auth($db->getConnection()->getPdo());
    });
	
    // Paginador 
    Paginator::currentPageResolver(function ($pageName = 'page') {
        return $_GET[$pageName] ?? 1;
    });

    // Configuración de Twig
    $container->set(Twig\Loader\LoaderInterface::class, function() {
        return new FilesystemLoader(__DIR__ . '/../templates');
    });
    $container->set(Twig::class, function ($container) {
        $loader = $container->get(Twig\Loader\LoaderInterface::class);
        return new Twig($loader, [
            'cache' => $_ENV['APP_ENV'] === 'production' 
                ? __DIR__ . '/../var/cache/twig' 
                : false,
            'debug' => $_ENV['APP_ENV'] === 'development'
        ]);
    });

    // Configurar Flash Messages en el contenedor
    $container->set('flash', function (ContainerInterface $container) {
        return new Messages();
    });


    // Alias para usar 'view' en lugar de Twig::class
    $container->set('view', function ($container) {
        $twig = $container->get(Twig::class);
        // Añade 'base_url' como variable global
        $twig->getEnvironment()->addGlobal('base_url', '/');
        // para dejar como global el nombre de usuario
        isset ($_SESSION['auth_username'] ) ? $twig->getEnvironment()->addGlobal('user_name', $_SESSION['auth_username'] ) : '';
        
        // Agregar flash messages como variable global en Twig
        $twig->getEnvironment()->addGlobal('flash', $container->get('flash'));

        // Filtro personalizado: "fecha_corta"
        $env = $twig->getEnvironment();
        $env->addFilter(new TwigFilter('fecha_corta', function ($fecha) {
            $timestamp = is_numeric($fecha) ? $fecha : strtotime($fecha);

             $formatter = new IntlDateFormatter(
                'es_ES', // Localización en español
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                null,
                null,
                "MMM dd 'de' yyyy" // 3 letras del mes
            );
            return $formatter->format($timestamp);
        }));



        return $twig;
    });




    $container->set(App\Middleware\AuthMiddleware::class, function ($container) {
        return new App\Middleware\AuthMiddleware($container->get(Auth::class));
    });



};
