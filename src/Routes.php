<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\AuthMiddleware;

use App\Controllers\AuthController;

use App\Controllers\BlogController;
use App\Controllers\PostController;
use App\Controllers\AutorController;
use App\Controllers\MsjController;
use App\Controllers\PrincipalController;

use App\Controllers\ContactoController;
use App\Controllers\AdminPostController;
use App\Controllers\PromotionController;
use Slim\App;

return function(App $app) {

    //probamos la conexion a la base de datos
    $app->get('/testdb', function (Request $request, Response $response, $args) use ($app) {
        try {
            $container = $app->getContainer();
            $db = $container->get('db');
            $connection = $db->getConnection();
            $connection->select('SELECT 1');
            $response->getBody()->write("✅ Conexión exitosa");
            return $response;
        } catch (\Exception $e) {
            $response->getBody()->write( "❌ Error de conexión: " . $e->getMessage());
            return $response;
        }
    });
    // probamos que twig funcione
    $app->get('/prueba', function ($request, $response, $args) {
        return $this->get('view')->render($response, 'prueba.twig', [
            'mensaje' => '¡Hola desde Twig Aldeanos!'
        ]);
    });

    // rutas relativas al sitio
    $app->get('/', BlogController::class . ':home')->setName('home');
    $app->get('/contacto', BlogController::class . ':contacto')->setName('contacto');
    $app->post('/contacto', ContactoController::class . ':procesarFormulario')->setName('procesaForm');

    $app->get('/tema/{tematica}[/{pagina:\d+}]', BlogController::class . ':tema')->setName('tema');
    $app->get('/nota/{tematica}[/{pagina:\d+}]', BlogController::class . ':nota')->setName('nota');
    $app->get('/blog', BlogController::class . ':index');
    $app->get('/convocatorias', BlogController::class . ':convocatorias')->setName('convocatorias');
    $app->get('/periodico', BlogController::class . ':periodico')->setName('periodico');
    $app->get('/entrada/{slug}', BlogController::class . ':show')->setName('entrada');
    $app->get('/login', [AuthController::class, 'showLogin']);

    // Grupo de rutas de autenticación
    $app->group('/cmspt', function ($group) {
        
        // Mostrar formularios (GET)
        $group->get('', [AuthController::class, 'showLogin']);
        $group->get('/login', [AuthController::class, 'showLogin']);
        $group->get('/register', [AuthController::class, 'showRegister']);
        $group->get('/forgot-password', [AuthController::class, 'showForgotPassword']);
        $group->get('/reset-password', [AuthController::class, 'showResetPassword']);
        
        $group->any('/logout', [AuthController::class, 'logout'])->setName('cmspt.logout');

        // Procesar formularios (POST)
        $group->post('/register', [AuthController::class, 'register']);
        $group->post('/login', [AuthController::class, 'login'])->setName('cmspt.login');
        $group->post('/forgot-password', [AuthController::class, 'forgotPassword']);
        $group->post('/reset-password', [AuthController::class, 'resetPassword']);
        
        // API endpoints
        $group->get('/me', [AuthController::class, 'me']);
        $group->post('/resend-verification', [AuthController::class, 'resendVerification']);
        $group->get('/verify', [AuthController::class, 'verifyEmail']);
        $group->post('/change-password', [AuthController::class, 'changePassword']);
    });


    $app->group('/admin', function ($group) {
        $group->get('/dashboard', AdminPostController::class . ':dashboard')->setName('admin.dashboard');
        $group->get('/posts', AdminPostController::class . ':index')->setName('admin.posts');
        $group->get('/posts/create', AdminPostController::class . ':create')->setName('admin.posts.create');
        $group->post('/posts/store', AdminPostController::class . ':store')->setName('admin.posts.store');
        $group->get('/posts/edit/{id}', AdminPostController::class . ':edit')->setName('admin.posts.edit');
        $group->post('/posts/update/{id}', AdminPostController::class . ':update')->setName('admin.posts.update');
        $group->post('/posts/delete/{id}', AdminPostController::class . ':delete')->setName('admin.posts.delete');

        // Rutas de Promociones (Pop-ups y Agenda)
        $group->get('/promotions', PromotionController::class . ':index')->setName('admin.promotions');
        $group->get('/promotions/create', PromotionController::class . ':create')->setName('admin.promotions.create');
        $group->post('/promotions/store', PromotionController::class . ':store')->setName('admin.promotions.store');
        $group->get('/promotions/edit/{id}', PromotionController::class . ':edit')->setName('admin.promotions.edit');
        $group->post('/promotions/update/{id}', PromotionController::class . ':update')->setName('admin.promotions.update');
        $group->post('/promotions/delete/{id}', PromotionController::class . ':delete')->setName('admin.promotions.delete');
    })->add(AuthMiddleware::class);


    $app->group('/post', function ($group) {
        $group->get('', [PostController::class, 'index'])->setName('post.index');
        $group->get('/create', [PostController::class, 'create'])->setName('post.create');
        $group->post('', [PostController::class, 'store'])->setName('post.store');
        $group->get('/{id}', [PostController::class, 'show'])->setName('post.show');
        $group->get('/{id}/edit', [PostController::class, 'edit'])->setName('post.edit');
        $group->post('/{id}', [PostController::class, 'update'])->setName('post.update');
        $group->post('/{id}/delete', [PostController::class, 'delete'])->setName('post.delete');

        $group->get('/ponfoto/{id}', [PostController::class, 'ponFoto'])->setName('post.ponfoto');
        $group->post('/ponfoto/{id}', [PostController::class, 'ponFotoUpdate'])->setName('post.ponfoto.update');
    })->add(AuthMiddleware::class); 


    $app->group('/autor', function ($group) {
        $group->get('', [AutorController::class, 'index'])->setName('autor.index');
        $group->get('/create', [AutorController::class, 'create'])->setName('autor.create');
        $group->post('', [AutorController::class, 'store'])->setName('autor.store');
        $group->get('/{id}', [AutorController::class, 'show'])->setName('autor.show');
        $group->get('/{id}/edit', [AutorController::class, 'edit'])->setName('autor.edit');
        $group->post('/{id}', [AutorController::class, 'update'])->setName('autor.update');
        $group->get('/{id}/delete', [AutorController::class, 'delete'])->setName('autor.delete');

        $group->get('/ponfoto/{id}', [AutorController::class, 'ponFoto'])->setName('autor.ponfoto');
        $group->post('/ponfoto/{id}', [AutorController::class, 'ponFotoUpdate'])->setName('autor.ponfoto.update');
    })->add(AuthMiddleware::class);    
    
    $app->group('/msj', function ($group) {
        $group->get('', [msjController::class, 'index'])->setName('mensaje.index');
        $group->get('/create', [msjController::class, 'create'])->setName('mensaje.create');
        $group->get('/{id}/show', [msjController::class, 'show'])->setName('mensaje.view');
        $group->post('', [msjController::class, 'store'])->setName('mensaje.store');
        $group->get('/{id}/edit', [msjController::class, 'edit'])->setName('mensaje.edit');
        $group->post('/{id}', [msjController::class, 'update'])->setName('mensaje.update');
        $group->get('/{id}/delete', [msjController::class, 'delete'])->setName('mensaje.delete');

    })->add(AuthMiddleware::class); 

    $app->group('/principal', function ($group) {
        $group->get('', [principalController::class, 'index'])->setName('principal.index');
        $group->get('/create', [principalController::class, 'create'])->setName('principal.create');
        $group->post('', [principalController::class, 'store'])->setName('principal.store');
        $group->get('/{id}/edit', [principalController::class, 'edit'])->setName('principal.edit');
        $group->post('/{id}', [principalController::class, 'update'])->setName('principal.update');
        $group->get('/{id}/show', [principalController::class, 'show'])->setName('principal.view');
        $group->get('/{id}/delete', [principalController::class, 'delete'])->setName('principal.delete');

        $group->get('/ponfoto/{id}', [principalController::class, 'ponFoto'])->setName('principal.ponfoto');
        $group->post('/ponfoto/{id}', [principalController::class, 'ponFotoUpdate'])->setName('principal.ponfoto.update');        

    })->add(AuthMiddleware::class); 

};
