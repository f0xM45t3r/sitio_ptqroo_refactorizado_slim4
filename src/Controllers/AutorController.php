<?php

namespace App\Controllers;

use App\Models\Author;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class AutorController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    // Listar todos los autores
    public function index(Request $request, Response $response)
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $autores = Author::withCount('posts')->orderBy('display_name', 'asc')->paginate(20, ['*'], 'page', $page);

        return $this->view->render($response, 'admin/autor/index.twig', [
            'autores' => $autores,
            'page' => $page
        ]);
    }

    // Mostrar formulario de creación
    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/autor/create.twig');
    }

    // Almacenar nuevo autor
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        
        $autor = new Author();
        $autor->display_name = $data['nombre'];
        $autor->charge = $data['cargo'];
        $autor->save();

        // Redirigir al listado
        return $response
            ->withHeader('Location', '/autor')
            ->withStatus(302);
    }

    // Mostrar un autor específico
    public function show(Request $request, Response $response, $args)
    {
        $autor = Author::where('slug', $args['slug'])->firstOrFail();
        return $this->view->render($response, 'admin/autor/show.twig', [
            'autor' => $autor
        ]);
    }

    // Mostrar formulario de edición
    public function edit(Request $request, Response $response, $args)
    {
        $autor = Author::findOrFail($args['id']);
        return $this->view->render($response, 'admin/autor/edit.twig', [
            'autor' => $autor
        ]);
    }

    // Actualizar autor
    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        
        $autor = Author::findOrFail($args['id']);
        $autor->display_name = $data['nombre'];
        $autor->charge = $data['cargo'];
        $autor->save();

        // Redirigir al detalle del autor
        return $response
            ->withHeader('Location', '/autor' . $autor->slug)
            ->withStatus(302);
    }

    // Eliminar autor
    public function delete(Request $request, Response $response, $args)
    {
        $autor = Author::findOrFail($args['id']);
        $autor->delete();

        // Redirigir al listado
        return $response
            ->withHeader('Location', '/autor')
            ->withStatus(302);
    }

    // Mostrar formulario pon foto
    public function ponFoto(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
                
        $autor = Author::findOrFail($args['id']);
                
        return $this->view->render($response, 'admin/autor/ponfoto.twig', ['autor' => $autor]);
    }


    // Actualizar la foto
    public function ponFotoUpdate(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        
        $id  = $args['id'];
        $x      = (int) $data['crop_x'];
        $y      = (int) $data['crop_y'];
        $width  = (int) $data['crop_width'];
        $height = (int) $data['crop_height'];

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'] ?? null; // 'image' es el 'name' de tu input file


        if (  $uploadedFile || $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $ext = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $filename = uniqid('img_', true) . '.' . $ext;
            $destination = __DIR__ . '/../../public_html/img/autores/' . $filename;
    
            // Obtener el tipo de imagen
            $mimeType = $uploadedFile->getClientMediaType();

            // Crear imagen desde el archivo subido según su tipo
            switch (strtolower($mimeType)) {
                case 'image/jpeg':
                case 'image/jpg':
                    $imgSrc = imagecreatefromjpeg($uploadedFile->getStream()->getMetadata('uri'));
                    break;
                case 'image/png':
                    $imgSrc = imagecreatefrompng($uploadedFile->getStream()->getMetadata('uri'));
                    break;
                case 'image/gif':
                    $imgSrc = imagecreatefromgif($uploadedFile->getStream()->getMetadata('uri'));
                    break;
                default:
                    // Tipo de imagen no soportado
                    throw new \Exception('Formato de imagen no soportado');
            }
            // Crear imagen de destino
            $imgDst = imagecreatetruecolor($width, $height);
            // Preservar transparencia para PNG y GIF
            if ($ext === 'png' || $ext === 'gif') {
                imagealphablending($imgDst, false);
                imagesavealpha($imgDst, true);
                $transparent = imagecolorallocatealpha($imgDst, 255, 255, 255, 127);
                imagefilledrectangle($imgDst, 0, 0, $width, $height, $transparent);
            }

            // Recortar la imagen
            imagecopyresampled(
                $imgDst, $imgSrc,
                0, 0, $x, $y,
                $width, $height,
                $width, $height
            );

            // Guardar la imagen recortada según su tipo
            switch (strtolower($ext)) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($imgDst, $destination, 90); // 90 es la calidad (0-100)
                    break;
                case 'png':
                    imagepng($imgDst, $destination, 9); // 9 es el nivel de compresión (0-9)
                    break;
                case 'gif':
                    imagegif($imgDst, $destination);
                    break;
            }

            // Liberar memoria
            imagedestroy($imgSrc);
            imagedestroy($imgDst);
        }

        //echo "vamos bien aledeanos, ya se guardo la imagen"; exit;
        
        $post = Author::findOrFail($args['id']);
        $post->url_media = $filename;
        $post->save();
            
        return $response->withHeader('Location', '/autor')->withStatus(302);
    }    

}