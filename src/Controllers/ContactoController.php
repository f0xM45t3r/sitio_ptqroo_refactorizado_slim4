<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Models\Post;
use App\Models\Contacto;

class ContactoController
{
    protected $view;

    public function __construct(Twig $view) { 
        $this->view = $view; 
    }
    
    // Mostrar formulario
    public function mostrarFormulario($request, $response, $args)
    {
        $csrf = $request->getAttribute('csrf');
        
        $html = $this->twig->render('formulario.html', [
            'csrf_name' => $csrf['csrf_name'],
            'csrf_value' => $csrf['csrf_value'],
            'messages' => $this->flash->getMessages()
        ]);
        
        $response->getBody()->write($html);
        return $response;
    }
    
    // Procesar formulario
    public function procesarFormulario($request, $response)
    {
        $datos = $request->getParsedBody();

        // Validación
        $errores = $this->validarDatos($datos);
             
        // Sanitizar datos
        $datosSanitizados = $this->sanitizarDatos($datos);
        
        // Agregar información adicional de seguridad
        $datosSanitizados['ip_address'] = $this->obtenerIP($request);
        $datosSanitizados['user_agent'] = $request->getHeaderLine('User-Agent');
        
        // Guardar en base de datos
        Contacto::create($datosSanitizados);
        
        /*if ($modelo->crear($datosSanitizados)) {
            $this->flash->addMessage('success', 'Mensaje enviado correctamente');
        } else {
            $this->flash->addMessage('error', 'Error al enviar el mensaje');
        }*/
        
        return $this->view->render( $response, 'handler/gracias.twig' );
    }
    
    // Página administrativa para listar contactos
    public function listarContactos($request, $response, $args)
    {
        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $filtroEstatus = $request->getQueryParams()['estatus'] ?? '';
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $modelo = new Contacto($this->pdo);
        $contactos = $modelo->obtenerTodos($limit, $offset, $filtroEstatus);
        $total = $modelo->contarTotal($filtroEstatus);
        $totalPages = ceil($total / $limit);
        $estadisticas = $modelo->obtenerEstadisticas();
        $estatusOptions = Contacto::getEstatusOptions();
        
        $html = $this->twig->render('admin/contactos.html', [
            'contactos' => $contactos,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'filtroEstatus' => $filtroEstatus,
            'estadisticas' => $estadisticas,
            'estatusOptions' => $estatusOptions
        ]);
        
        $response->getBody()->write($html);
        return $response;
    }
    
    // Actualizar estatus de un contacto
    public function actualizarEstatus($request, $response, $args)
    {
        $id = (int)$args['id'];
        $datos = $request->getParsedBody();
        
        $nuevoEstatus = $datos['estatus'] ?? '';
        $notas = $datos['notas'] ?? '';
        $adminUsuario = $_SESSION['admin_usuario'] ?? 'admin';
        
        $estatusValidos = array_keys(Contacto::getEstatusOptions());
        
        if (!in_array($nuevoEstatus, $estatusValidos)) {
            $response->getBody()->write(json_encode(['error' => 'Estatus inválido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
        
        $modelo = new Contacto();
        $resultado = $modelo->actualizarEstatus($id, $nuevoEstatus, $adminUsuario, $notas);
        
        if ($resultado) {
            $response->getBody()->write(json_encode(['success' => true, 'message' => 'Estatus actualizado correctamente']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Error al actualizar el estatus']));
        }
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    // Validación de datos
    private function validarDatos(array $datos): array
    {
        $errores = [];
        
        if (empty($datos['nombre']) || strlen($datos['nombre']) < 2) {
            $errores[] = 'El nombre es requerido y debe tener al menos 2 caracteres';
        }
        
        if (empty($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Email válido es requerido';
        }
        
        if (!empty($datos['telefono']) && !preg_match('/^[\d\s\-\+\(\)]+$/', $datos['telefono'])) {
            $errores[] = 'Formato de teléfono inválido';
        }
        
        if (empty($datos['asunto']) || strlen($datos['asunto']) < 5) {
            $errores[] = 'El asunto es requerido y debe tener al menos 5 caracteres';
        }
        
        if (empty($datos['mensaje']) || strlen($datos['mensaje']) < 10) {
            $errores[] = 'El mensaje es requerido y debe tener al menos 10 caracteres';
        }
        
        return $errores;
    }
    
    // Sanitización de datos
    private function sanitizarDatos(array $datos): array
    {
        return [
            'nombre' => htmlspecialchars(trim($datos['nombre']), ENT_QUOTES, 'UTF-8'),
            'email' => filter_var(trim($datos['email']), FILTER_SANITIZE_EMAIL),
            'telefono' => !empty($datos['telefono']) ? preg_replace('/[^0-9\s\-\+\(\)]/', '', $datos['telefono']) : null,
            'asunto' => htmlspecialchars(trim($datos['asunto']), ENT_QUOTES, 'UTF-8'),
            'mensaje' => htmlspecialchars(trim($datos['mensaje']), ENT_QUOTES, 'UTF-8'),
            'estatus' => 'nuevo'
        ];
    }
    
    // Obtener IP real del usuario
    private function obtenerIP($request): string
    {
        $serverParams = $request->getServerParams();
        
        if (!empty($serverParams['HTTP_CLIENT_IP'])) {
            return $serverParams['HTTP_CLIENT_IP'];
        } elseif (!empty($serverParams['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $serverParams['HTTP_X_FORWARDED_FOR'])[0];
        } elseif (!empty($serverParams['HTTP_X_FORWARDED'])) {
            return $serverParams['HTTP_X_FORWARDED'];
        } elseif (!empty($serverParams['HTTP_FORWARDED_FOR'])) {
            return $serverParams['HTTP_FORWARDED_FOR'];
        } elseif (!empty($serverParams['HTTP_FORWARDED'])) {
            return $serverParams['HTTP_FORWARDED'];
        } else {
            return $serverParams['REMOTE_ADDR'] ?? 'unknown';
        }
    }
}