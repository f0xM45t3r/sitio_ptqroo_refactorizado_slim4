<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Views\Twig;
use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use App\Models\Principal;
use App\Models\Promotion;

use Slim\Csrf\Guard;

class BlogController {
    protected $view;

    public function __construct(Twig $view) { 
        $this->view = $view; 
    }


    public function home(Request $req, Response $res): Response {
        $activo = 'inicio';

        $principales = Principal::orderBy('id', 'desc')->limit(2)->get();
        $noticias = Post::orderBy('id', 'desc')->limit(3)->get();
        $opiniones = Post::orderBy('id', 'desc')->where('category_id',6)->limit(4)->get();
        
        // Obtener las 3 promociones más recientes para el Pop-up (carrusel)
        $promo_carousel = Promotion::active()->upcoming()->limit(3)->get();
        
        // Obtener los próximos 3 eventos para la agenda
        $upcoming_events = Promotion::upcoming()->limit(3)->get();

        return $this->view->render($res, 'blog/home.twig', compact([
            'activo',
            'principales',
            'noticias',
            'opiniones',
            'promo_carousel',
            'upcoming_events'
        ]));
    }

    public function contacto (Request $req, Response $res): Response {
        $activo = 'contacto';

        return $this->view->render($res, 'blog/contacto.twig', compact('activo'));
    }

    public function tema (Request $req, Response $res,array $args): Response {
        $activo = 'tematica';
        $tematica = $args['tematica'];
        $page = isset($args['pagina']) ? (int)$args['pagina'] : 1;

        try {
            // Obtiene el nombre de la categoría a partir del slug
            $category = Category::where('slug', $tematica)->firstOrFail();
            $categoryName = $category->name;

            $posts = Post::with('category')
                ->whereHas('category', function($query) use ($tematica) {
                    $query->where('slug', $tematica);
                })
                ->orderBy('published_at', 'desc')
                ->paginate(12, ['*'], 'page', $page);

            return $this->view->render($res, 'blog/tema.twig', compact(['activo','categoryName','tematica','posts']));
        } catch (ModelNotFoundException $e) {
            return $this->view->render($res, 'handler/404.twig');
        }
    }    

    public function nota (Request $req, Response $res,array $args): Response {
        $activo = 'salaprensa';
        $tematica = $args['tematica'];

        try {
            // Obtiene el nombre de la categoría a partir del slug
            $category = Category::where('slug', $tematica)->firstOrFail();
            $categoryName = $category->name;

            $params = $req->getQueryParams();
            $page = isset($params['page']) ? (int)$params['page'] : 1;

            $posts = Post::with('category')
                ->whereHas('category', function($query) use ($tematica) {
                    $query->where('slug', $tematica);
                })
                ->orderBy('published_at', 'desc')
                ->paginate(12, ['*'], 'page', $page);

            return $this->view->render($res, 'blog/nota.twig', compact(['activo','categoryName','tematica','posts']));
        } catch (ModelNotFoundException $e) {
            return $this->view->render($res, 'handler/404.twig');
        }
    }   

    public function index(Request $req, Response $res): Response {
        $categories = Category::all();
        return $this->view->render($res, 'blog/index.twig', compact('categories'));
    }

    public function convocatorias(Request $req, Response $res): Response {
        $activo = 'convocatorias';
        // Obtener todos los eventos a partir de la fecha actual
        $eventos = Promotion::upcoming()->orderBy('event_date', 'asc')->get();
        return $this->view->render($res, 'blog/convocatorias.twig', compact('activo', 'eventos'));
    }

    public function periodico (Request $req, Response $res): Response {
        $latestPosts = Post::orderBy('published_at', 'desc')->limit(5)->get();
        $ant = Post::find(1);
        $sig = Post::find(2);        
        
        return $this->view->render($res, 'blog/periodico.twig', compact(['latestPosts', 'ant', 'sig'] )  );
    }




    public function category(Request $req, Response $res, $args): Response {
        
        $category = Category::where('slug', $args['category'])->firstOrFail();
        $posts = Post::where('category_id', $category->id)
                     ->whereNotNull('published_at')
                     ->orderBy('published_at','desc')
                     ->get();
        return $this->view->render($res, 'blog/category.twig', compact('category','posts'));
    }

    public function show(Request $req, Response $res, $args): Response {
        try{
            $post = Post::with('htmlContent')->where('slug', $args['slug'])->firstOrFail();
            $latestPosts = Post::orderBy('published_at', 'desc')->limit(5)->get();
            $id = $post->id;
            $ant = Post::find($id-1);
            $sig = Post::find($id+1);
            return $this->view->render($res, 'blog/entrada.twig', compact(['post','latestPosts', 'ant', 'sig'] ));
        }catch (ModelNotFoundException $e) {
            // Redirigir a tu 404 personalizada
            return $this->view->render($res, 'handler/404.twig');
        }
    }
}
