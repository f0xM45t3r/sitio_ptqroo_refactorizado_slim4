<?php

namespace App\Controllers;

use App\Models\Principal;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class PrincipalController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    // Listar todos los temas principales
    public function index(Request $request, Response $response)
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $principales = Principal::orderBy('id', 'desc')->paginate(20, ['*'], 'page', $page);

        return $this->view->render($response, 'admin/principal/index.twig', [
            'principales' => $principales,
            'page' => $page
        ]);
    }

    // Mostrar formulario de creación
    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/principal/create.twig');
    }

    // Almacenar nuevo mensaje
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        
        $principal = new Principal();
        $principal->intro = $data['intro'];
        $principal->titulo = $data['titulo'];
        $principal->balazo = $data['balazo'];
        $principal->id_post = $data['id_post'];
        // Convertir checkbox a valor ENUM
        $principal->publicar = isset($data['publicar']) && $data['publicar'] == 'y' ? 'y' : 'n';

        
        $principal->save();

        //echo "<pre>"; print_r($principal); echo "</pre>"; exit;

        // Redirigir al listado
        return $response
            ->withHeader('Location', '/principal')
            ->withStatus(302);
    }

    // Mostrar un mensaje específico
    public function show(Request $request, Response $response, $args)
    {
        $principal = Principal::where('id', $args['id'])->firstOrFail();

        return $this->view->render($response, 'admin/principal/show.twig', [
            'registro' => $mensaje
        ]);
    }

    // Mostrar formulario de edición
    public function edit(Request $request, Response $response, $args)
    {
        $principal = Principal::findOrFail($args['id']);

        return $this->view->render($response, 'admin/principal/edit.twig', [
            'principal' => $principal,
        ]);
    }

    // Actualizar autor
    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $principal = Principal::findOrFail($args['id']);

        $principal->intro = $data['intro'];
        $principal->titulo = $data['titulo'];
        $principal->balazo = $data['balazo'];
        $principal->id_post = $data['id_post'];
        // Convertir checkbox a valor ENUM
        $principal->publicar = isset($data['publicar']) && $data['publicar'] == 'y' ? 'y' : 'n';

        $principal->save();

        // Redirigir al index de mensajes
        return $response
            ->withHeader('Location', '/principal')
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

    // Mostrar formulario pon foto
    public function ponFoto(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
                
        $autor = Principal::findOrFail($args['id']);
                
        return $this->view->render($response, 'admin/principal/ponfoto.twig', ['autor' => $autor]);
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
            $filename = uniqid('imgb_', true) . '.' . $ext;
            $destination = __DIR__ . '/../../public_html/img/main/' . $filename;
    
            //echo ($destination); exit();
            
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
                    throw new Exception('Formato de imagen no soportado');
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

        //echo "vamos bien, ya se guardo la imagen"; exit;
        
        $post = Principal::findOrFail($args['id']);
        $post->url_media = $filename;
        $post->save();
            
        return $response->withHeader('Location', '/principal')->withStatus(302);
    }    

}