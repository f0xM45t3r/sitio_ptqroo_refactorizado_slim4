<?php

namespace App\Controllers;

use App\Models\Promotion;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class PromotionController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    // Listado de promociones en el admin
    public function index(Request $request, Response $response)
    {
        $promotions = Promotion::orderBy('id', 'desc')->get();
        return $this->view->render($response, 'admin/promotion/index.twig', [
            'promotions' => $promotions
        ]);
    }

    // Formulario de creación
    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/promotion/create.twig');
    }

    // Guardar nueva promoción
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $image = $files['image'] ?? null;

        $filename = null;
        if ($image && $image->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($image);
        }

        Promotion::create([
            'title'          => $data['title'],
            'image_path'     => $filename,
            'link_url'       => $data['link_url'] ?? null,
            'button_text'    => $data['button_text'] ?? null,
            'event_date'     => $data['event_date'] ?: null,
            'event_location' => $data['event_location'] ?? null,
            'is_active'      => isset($data['is_active']),
            'starts_at'      => $data['starts_at'] ?: null,
            'ends_at'        => $data['ends_at'] ?: null,
        ]);

        return $response->withHeader('Location', '/admin/promotions')->withStatus(302);
    }

    // Formulario de edición
    public function edit(Request $request, Response $response, array $args)
    {
        $promotion = Promotion::findOrFail($args['id']);
        return $this->view->render($response, 'admin/promotion/edit.twig', [
            'promotion' => $promotion
        ]);
    }

    // Actualizar promoción
    public function update(Request $request, Response $response, array $args)
    {
        $promotion = Promotion::findOrFail($args['id']);
        $data = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $image = $files['image'] ?? null;

        if ($image && $image->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($image);
            $promotion->image_path = $filename;
        }

        $promotion->update([
            'title'          => $data['title'],
            'link_url'       => $data['link_url'] ?? null,
            'button_text'    => $data['button_text'] ?? null,
            'event_date'     => $data['event_date'] ?: null,
            'event_location' => $data['event_location'] ?? null,
            'is_active'      => isset($data['is_active']),
            'starts_at'      => $data['starts_at'] ?: null,
            'ends_at'        => $data['ends_at'] ?: null,
        ]);

        return $response->withHeader('Location', '/admin/promotions')->withStatus(302);
    }

    // Eliminar promoción
    public function delete(Request $request, Response $response, array $args)
    {
        $promotion = Promotion::findOrFail($args['id']);
        $promotion->delete();
        return $response->withHeader('Location', '/admin/promotions')->withStatus(302);
    }

    // Función auxiliar para mover el archivo subido
    private function moveUploadedFile($uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $directory = __DIR__ . '/../../public_html/img/promos';
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
