<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Delight\Auth\Auth;

class AdminPostController {
    protected $view;
    protected $auth;

    public function __construct(Twig $view, Auth $auth) {
        $this->view = $view;
        $this->auth = $auth;
    }

    public function dashboard(Request $request, Response $response): Response {

        return $this->view->render($response, 'admin/dashboard.twig' );
    }    

    public function index(Request $request, Response $response): Response {
        $posts = Post::with('category')->orderByDesc('created_at')->get();
        return $this->view->render($response, 'admin/posts/index.twig', compact('posts'));
    }

    public function create(Request $request, Response $response): Response {
        $categories = Category::all();
        return $this->view->render($response, 'admin/posts/create.twig', compact('categories'));
    }

    public function store(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        
        Post::create([
            'title'       => $data['title'],
            'slug'        => strtolower(str_replace(' ', '-', $data['title'])),
            'content'     => $data['content'],
            'category_id' => $data['category_id'],
            'user_id'     => $this->auth->getUserId(),
            'published_at'=> $data['published_at'] ?? null,
        ]);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response
            ->withHeader('Location', $routeParser->urlFor('admin.posts'))
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $post = Post::findOrFail($args['id']);
        $categories = Category::all();
        return $this->view->render($response, 'admin/posts/edit.twig', compact('post', 'categories'));
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $post = Post::findOrFail($args['id']);

        $post->update([
            'title'       => $data['title'],
            'slug'        => strtolower(str_replace(' ', '-', $data['title'])),
            'content'     => $data['content'],
            'category_id' => $data['category_id'],
            'published_at'=> $data['published_at'] ?? null,
        ]);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response
            ->withHeader('Location', $routeParser->urlFor('admin.posts'))
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $post = Post::findOrFail($args['id']);
        $post->delete();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response
            ->withHeader('Location', $routeParser->urlFor('admin.posts'))
            ->withStatus(302);
    }
}
