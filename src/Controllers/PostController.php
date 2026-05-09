<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\HtmlContent;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Str; // Usa el helper Str de Illuminate
use Slim\Views\Twig;
use App\Models\Author;
use App\Models\Category;



class PostController {
    private $view;

    public function __construct(Twig $view) {
        $this->view = $view;
    }

    public function index(Request $request, Response $response) {
        $params = $request->getQueryParams();
        $page = $params['page'] ?? 1;
        $categoryId = $params['category_id'] ?? null;

        $query = Post::with(['category', 'author']);

        // Aplicar filtro si existe
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Ordenar por categoría y luego por fecha
        $posts = $query->orderBy('category_id', 'asc')
                      ->orderBy('published_at', 'desc')
                      ->paginate(20, ['*'], 'page', $page);

        $categories = Category::all();

        return $this->view->render($response, 'admin/post/index.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'current_category' => $categoryId
        ]);
    }

    // Obtener datos para DataTables (AJAX)
    public function datatable(Request $request, Response $response) {
        $query = Post::query();
        
        // Obtener parámetros de DataTables
        $params = $request->getQueryParams();
        $draw = $params['draw'] ?? 1;
        $start = $params['start'] ?? 0;
        $length = $params['length'] ?? 10;
        $search = $params['search']['value'] ?? '';
        
        // Total de registros
        $totalRecords = Post::count();
        
        // Aplicar búsqueda si existe
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%")
                  ->orWhere('slug', 'like', "%$search%");
            });
        }
        
        // Total de registros después de filtrar
        $filteredRecords = $query->count();
        
        // Ordenación
        if (isset($params['order'])) {
            $columns = [
                0 => 'id',
                1 => 'title',
                2 => 'author_id',
                3 => 'category_id',
                4 => 'published_at'
            ];
            
            $orderColumn = $columns[$params['order'][0]['column']] ?? 'id';

            $orderDirection = $params['order'][0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);
        }
        
        // Paginación
        $posts = $query->skip($start)->take($length)->get();
        
        $data = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $posts
        ];
        
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mostrar formulario de creación
    public function create(Request $request, Response $response) {
        $autores = Author::all();
        $categorias = Category::all();

        //var_dump($autores->toArray());
        //die;
        return $this->view->render($response, 'admin/post/create.twig',['autores' => $autores, 'categorias' => $categorias]);
    }

    // Guardar nuevo post
    public function store(Request $request, Response $response) {
        $data = $request->getParsedBody();
        $title = $data['title'];
        $slugBase = Str::slug($title);  

        $slug = $slugBase;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter;
            $counter++;
        }
        // Una vez que es único, lo usas:
        $post = new Post();
        $post->title = $title;
        $post->slug = $slug;
        $post->content = $data['content'];

        $post->author_id = $data['author_id'];
        $post->category_id = $data['category_id'];
        $post->quote = $data['quote'];
        $post->published_at = $data['published_at'];
        // var_dump($post); exit;
        $post->save();
        
        // Guardar contenido HTML si existe
        if (!empty($data['html_content'])) {
            HtmlContent::create([
                'post_id' => $post->id,
                'html_content' => $data['html_content']
            ]);
        }
        
       
        return $response->withHeader('Location', '/post')->withStatus(302);
    }

    // Mostrar un post
    public function show(Request $request, Response $response, array $args) {
        $post = Post::findOrFail($args['id']);
        return $this->view->render($response, 'posts/view.html.twig', ['post' => $post]);
    }

    // Mostrar formulario de edición
    public function edit(Request $request, Response $response, array $args) {
        $post = Post::findOrFail($args['id']);
        $autores = Author::all(); // Obtiene todos los autores
        $categorias = Category::all(); // Obtiene todos los autores


        return $this->view->render($response, 'admin/post/edit.twig', ['post' => $post, 'autores' => $autores, 'categorias' => $categorias]);
    }

    // Actualizar post
    public function update(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
                
        $post = Post::findOrFail($args['id']);
        $post->fill($data);

        //echo "fecha: ". $data['published_at']; exit;
        
        $post->save();

        // Actualizar o crear contenido HTML
        if (isset($data['html_content'])) {
            HtmlContent::updateOrCreate(
                ['post_id' => $post->id],
                ['html_content' => $data['html_content']]
            );
        }
        
        return $response->withHeader('Location', '/post')->withStatus(302);
    }

    // Eliminar post
    public function delete(Request $request, Response $response, array $args) {

        
        $post = Post::findOrFail($args['id']);
        $post->delete();
        
        return $response->withHeader('Location', '/post')->withStatus(302);
    }

    // Mostrar formulario pon foto
    public function ponFoto(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
            
        $post = Post::findOrFail($args['id']);
            
        return $this->view->render($response, 'admin/post/ponfoto.twig', ['post' => $post]);
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
            $destination = __DIR__ . '/../../public_html/img/blog/' . $filename;
    
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

        //echo "vamos bien aledeanos, ya se guardo la imagen"; exit;
        
        $post = Post::findOrFail($args['id']);
        $post->url_media = $filename;
        $post->save();
            
        return $response->withHeader('Location', '/post')->withStatus(302);
    }    
}
?>