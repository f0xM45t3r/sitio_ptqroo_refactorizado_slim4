<?php

namespace App\Controllers;

use App\Models\Mensaje;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class MsjController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    // Listar todos los mensajes
    public function index(Request $request, Response $response)
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $mensajes = Mensaje::orderBy('id', 'desc')->paginate(20, ['*'], 'page', $page);

        return $this->view->render($response, 'admin/mensaje/index.twig', [
            'mensajes' => $mensajes,
            'page' => $page
        ]);
    }

    // Mostrar formulario de creación
    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/mensaje/create.twig');
    }

    // Almacenar nuevo mensaje
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        
        $autor = new Category();
        $autor->display_name = $data['nombre'];
        $autor->charge = $data['cargo'];
        $autor->save();

        // Redirigir al listado
        return $response
            ->withHeader('Location', '/autor')
            ->withStatus(302);
    }

    // Mostrar un mensaje específico
    public function show(Request $request, Response $response, $args)
    {
        $mensaje = Mensaje::where('id', $args['id'])->firstOrFail();
        return $this->view->render($response, 'admin/mensaje/show.twig', [
            'registro' => $mensaje
        ]);
    }

    // Mostrar formulario de edición
    public function edit(Request $request, Response $response, $args)
    {
        $mensaje = Mensaje::findOrFail($args['id']);
        $estados = ['nuevo', 'leido', 'en_proceso', 'respondido', 'resuelto', 'cerrado', 'spam'];

        return $this->view->render($response, 'admin/mensaje/edit.twig', [
            'mensaje' => $mensaje,
            'estados' => $estados
        ]);
    }

    // Actualizar autor
    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $mensaje = Mensaje::findOrFail($args['id']);
        $mensaje->estatus = $data['estatus'];
        $mensaje->notas_admin = $data['notas_admin'];
        $mensaje->save();

        // Redirigir al index de mensajes
        return $response
            ->withHeader('Location', '/msj')
            ->withStatus(302);
    }

    // Eliminar autor
    public function delete(Request $request, Response $response, $args)
    {
        $autor = Category::findOrFail($args['id']);
        $autor->delete();

        // Redirigir al listado
        return $response
            ->withHeader('Location', '/autor')
            ->withStatus(302);
    } 

}