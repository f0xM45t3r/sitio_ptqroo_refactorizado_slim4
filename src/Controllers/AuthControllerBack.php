<?php

namespace App\Controllers;

// Interfaces y clases de Slim y PSR
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Delight\Auth\Auth;

use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\UserAlreadyExistsException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\DuplicateUsernameException;

use Slim\Views\Twig;

class AuthController
{
    private Auth $auth;
    private Twig $view;

    public function __construct(Auth $auth, Twig $view)
    {
        $this->auth = $auth;
        $this->view = $view;
    }

    


    /**
     * Mostrar formulario de registro
     */
    public function showRegister(Request $request, Response $response): Response
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->auth->isLoggedIn()) {
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        $html = $this->getRegisterForm();
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * Registro de usuario
     */
    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $username = $data['username'] ?? null;

        try {
            if ($username) {
                $userId = $this->auth->registerWithUniqueUsername($email, $password, $username);
            } else {
                $userId = $this->auth->register($email, $password);
            }

            $responseData = [
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'user_id' => $userId,
                'requires_verification' => !$this->auth->isLoggedIn()
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (InvalidEmailException $e) {
            return $this->errorResponse($response, 'Email inválido', 400);
        } catch (InvalidPasswordException $e) {
            return $this->errorResponse($response, 'Contraseña inválida (mínimo 8 caracteres)', 400);
        } catch (UserAlreadyExistsException $e) {
            return $this->errorResponse($response, 'El usuario ya existe', 409);
        } catch (DuplicateUsernameException $e) {
            return $this->errorResponse($response, 'El nombre de usuario ya está en uso', 409);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Mostrar formulario de login
     */
    public function showLogin(Request $request, Response $response): Response
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->auth->isLoggedIn()) {
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        $html = $this->getLoginForm();
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * Inicio de sesión
     */
    public function login(Request $request, Response $response): Response
    {
        try {
            // Obtener datos del request
            $contentType = $request->getHeaderLine('Content-Type');
            
            if (strpos($contentType, 'application/json') !== false) {
                // Petición JSON (AJAX)
                $body = $request->getBody()->getContents();
                $data = json_decode($body, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return $this->errorResponse($response, 'JSON inválido', 400);
                }
            } else {
                // Petición de formulario tradicional
                $data = $request->getParsedBody();
            }
            
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
            $rememberMe = isset($data['remember_me']) && ($data['remember_me'] == '1' || $data['remember_me'] === true);

            if (empty($email) || empty($password)) {
                return $this->errorResponse($response, 'Email y contraseña son requeridos', 400);
            }

            if ($rememberMe) {
                $this->auth->login($email, $password, (60 * 60 * 24 * 30)); // 30 días
            } else {
                $this->auth->login($email, $password);
            }

            $user = $this->auth->getUser();
            
            $responseData = [
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'username' => $user->getUsername(),
                    'verified' => $user->isVerified(),
                    'roles' => $this->auth->getRoles()
                ]
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (InvalidEmailException $e) {
            return $this->errorResponse($response, 'Email inválido', 400);
        } catch (InvalidPasswordException $e) {
            return $this->errorResponse($response, 'Contraseña incorrecta', 401);
        } catch (EmailNotVerifiedException $e) {
            return $this->errorResponse($response, 'Email no verificado', 401);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en login: " . $e->getMessage());
            return $this->errorResponse($response, 'Error interno del servidor', 500);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request, Response $response): Response
    {
        try {
            $this->auth->logOut();
            
            $responseData = [
                'success' => true,
                'message' => 'Sesión cerrada correctamente'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (NotLoggedInException $e) {
            return $this->errorResponse($response, 'No hay sesión activa', 400);
        }
    }

    /**
     * Obtener información del usuario actual
     */
    public function me(Request $request, Response $response): Response
    {
        if (!$this->auth->isLoggedIn()) {
            return $this->errorResponse($response, 'No autenticado', 401);
        }

        $user = $this->auth->getUser();
        
        $responseData = [
            'success' => true,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'verified' => $user->isVerified(),
                'roles' => $this->auth->getRoles(),
                'registered' => $user->getRegistered()
            ]
        ];

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Reenviar email de verificación
     */
    public function resendVerification(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';

        try {
            $this->auth->resendConfirmationForEmail($email, function ($selector, $token) {
                // Aquí puedes personalizar el envío del email
                // Por ejemplo, usar un servicio de email como PHPMailer
                $verificationUrl = "https://tu-dominio.com/verify?selector=$selector&token=$token";
                
                // Enviar email (implementa tu lógica de envío aquí)
                $this->sendVerificationEmail($email, $verificationUrl);
            });

            $responseData = [
                'success' => true,
                'message' => 'Email de verificación enviado'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Verificar email
     */
    public function verifyEmail(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $selector = $params['selector'] ?? '';
        $token = $params['token'] ?? '';

        try {
            $this->auth->confirmEmail($selector, $token);

            $responseData = [
                'success' => true,
                'message' => 'Email verificado correctamente'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (InvalidSelectorTokenPairException $e) {
            return $this->errorResponse($response, 'Token de verificación inválido', 400);
        } catch (TokenExpiredException $e) {
            return $this->errorResponse($response, 'Token de verificación expirado', 400);
        } catch (UserAlreadyExistsException $e) {
            return $this->errorResponse($response, 'Email ya verificado', 400);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Mostrar formulario de contraseña olvidada
     */
    public function showForgotPassword(Request $request, Response $response): Response
    {
        $html = $this->getForgotPasswordForm();
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * Solicitar restablecimiento de contraseña
     */
    public function forgotPassword(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';

        try {
            $this->auth->forgotPassword($email, function ($selector, $token) use ($email) {
                // Crear URL de restablecimiento
                $resetUrl = "https://tu-dominio.com/reset-password?selector=$selector&token=$token";
                
                // Enviar email (implementa tu lógica de envío aquí)
                $this->sendPasswordResetEmail($email, $resetUrl);
            });

            $responseData = [
                'success' => true,
                'message' => 'Email de restablecimiento enviado'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (InvalidEmailException $e) {
            return $this->errorResponse($response, 'Email inválido', 400);
        } catch (EmailNotVerifiedException $e) {
            return $this->errorResponse($response, 'Email no verificado', 400);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Mostrar formulario de restablecimiento de contraseña
     */
    public function showResetPassword(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $selector = $params['selector'] ?? '';
        $token = $params['token'] ?? '';

        if (empty($selector) || empty($token)) {
            return $this->errorResponse($response, 'Token de restablecimiento inválido', 400);
        }

        $html = $this->getResetPasswordForm($selector, $token);
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * Restablecer contraseña
     */
    public function resetPassword(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $selector = $data['selector'] ?? '';
        $token = $data['token'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $this->auth->resetPassword($selector, $token, $password);

            $responseData = [
                'success' => true,
                'message' => 'Contraseña restablecida correctamente'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (InvalidSelectorTokenPairException $e) {
            return $this->errorResponse($response, 'Token de restablecimiento inválido', 400);
        } catch (TokenExpiredException $e) {
            return $this->errorResponse($response, 'Token de restablecimiento expirado', 400);
        } catch (InvalidPasswordException $e) {
            return $this->errorResponse($response, 'Contraseña inválida (mínimo 8 caracteres)', 400);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Cambiar contraseña (usuario autenticado)
     */
    public function changePassword(Request $request, Response $response): Response
    {
        if (!$this->auth->isLoggedIn()) {
            return $this->errorResponse($response, 'No autenticado', 401);
        }

        $data = $request->getParsedBody();
        $oldPassword = $data['old_password'] ?? '';
        $newPassword = $data['new_password'] ?? '';

        try {
            $this->auth->changePassword($oldPassword, $newPassword);

            $responseData = [
                'success' => true,
                'message' => 'Contraseña cambiada correctamente'
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (NotLoggedInException $e) {
            return $this->errorResponse($response, 'No autenticado', 401);
        } catch (InvalidPasswordException $e) {
            return $this->errorResponse($response, 'Contraseña actual incorrecta o nueva contraseña inválida', 400);
        } catch (TooManyRequestsException $e) {
            return $this->errorResponse($response, 'Demasiados intentos. Intenta más tarde', 429);
        }
    }

    /**
     * Método auxiliar para respuestas de error
     */
    private function errorResponse(Response $response, string $message, int $status = 400): Response
    {
        $responseData = [
            'success' => false,
            'message' => $message
        ];

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    /**
     * Método placeholder para envío de email de verificación
     * Implementa tu lógica de envío de emails aquí
     */
    private function sendVerificationEmail(string $email, string $verificationUrl): void
    {
        // Implementar envío de email
        // Ejemplo con PHPMailer, Symfony Mailer, etc.
    }

    /**
     * Método placeholder para envío de email de restablecimiento
     * Implementa tu lógica de envío de emails aquí
     */
    private function sendPasswordResetEmail(string $email, string $resetUrl): void
    {
        // Implementar envío de email
        // Ejemplo con PHPMailer, Symfony Mailer, etc.
    }

    /**
     * Generar formulario de login
     */
    private function getLoginForm(): string
    {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Iniciar Sesión</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
                button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
                button:hover { background: #0056b3; }
                .links { text-align: center; margin-top: 20px; }
                .links a { color: #007bff; text-decoration: none; margin: 0 10px; }
                .error { color: red; margin-top: 10px; }
                .success { color: green; margin-top: 10px; }
            </style>
        </head>
        <body>
            <h2>Iniciar Sesión</h2>
            <form id="loginForm" method="POST" action="/auth/login">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember_me" value="1"> Recordarme
                    </label>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <div class="links">
                <a href="/auth/register">¿No tienes cuenta? Regístrate</a><br>
                <a href="/auth/forgot-password">¿Olvidaste tu contraseña?</a>
            </div>
            <div id="message"></div>
            
            <script>
                document.getElementById("loginForm").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    
                    // Mostrar mensaje de carga
                    const messageDiv = document.getElementById("message");
                    messageDiv.innerHTML = "<div style=\"color: blue;\">Procesando...</div>";
                    
                    try {
                        console.log("Enviando datos:", data); // Debug
                        
                        const response = await fetch("/auth/login", {
                            method: "POST",
                            headers: { 
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify(data)
                        });
                        
                        console.log("Respuesta status:", response.status); // Debug
                        console.log("Respuesta headers:", response.headers.get("content-type")); // Debug
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        const contentType = response.headers.get("content-type");
                        if (!contentType || !contentType.includes("application/json")) {
                            const textResponse = await response.text();
                            console.log("Respuesta no JSON:", textResponse); // Debug
                            throw new Error("La respuesta no es JSON válido");
                        }
                        
                        const result = await response.json();
                        console.log("Resultado:", result); // Debug
                        
                        if (result.success) {
                            messageDiv.innerHTML = "<div class=\"success\">" + result.message + "</div>";
                            setTimeout(() => { window.location.href = "/dashboard"; }, 1000);
                        } else {
                            messageDiv.innerHTML = "<div class=\"error\">" + result.message + "</div>";
                        }
                    } catch (error) {
                        console.error("Error completo:", error); // Debug
                        messageDiv.innerHTML = "<div class=\"error\">Error de conexión: " + error.message + "</div>";
                    }
                });
            </script>
        </body>
        </html>';
    }

    /**
     * Generar formulario de registro
     */
    private function getRegisterForm(): string
    {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registro</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input[type="email"], input[type="password"], input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
                button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
                button:hover { background: #218838; }
                .links { text-align: center; margin-top: 20px; }
                .links a { color: #007bff; text-decoration: none; }
                .error { color: red; margin-top: 10px; }
                .success { color: green; margin-top: 10px; }
            </style>
        </head>
        <body>
            <h2>Registro</h2>
            <form id="registerForm" method="POST" action="/auth/register">
                <div class="form-group">
                    <label for="username">Nombre de usuario (opcional):</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small>Mínimo 8 caracteres</small>
                </div>
                <button type="submit">Registrarse</button>
            </form>
            <div class="links">
                <a href="/auth/login">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
            <div id="message"></div>
            
            <script>
                document.getElementById("registerForm").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    
                    try {
                        const response = await fetch("/auth/register", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(data)
                        });
                        
                        const result = await response.json();
                        const messageDiv = document.getElementById("message");
                        
                        if (result.success) {
                            messageDiv.innerHTML = "<div class=\"success\">" + result.message + "</div>";
                            if (result.requires_verification) {
                                messageDiv.innerHTML += "<div class=\"success\">Revisa tu email para verificar tu cuenta</div>";
                            }
                        } else {
                            messageDiv.innerHTML = "<div class=\"error\">" + result.message + "</div>";
                        }
                    } catch (error) {
                        document.getElementById("message").innerHTML = "<div class=\"error\">Error de conexión</div>";
                    }
                });
            </script>
        </body>
        </html>';
    }

    /**
     * Generar formulario de contraseña olvidada
     */
    private function getForgotPasswordForm(): string
    {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recuperar Contraseña</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
                button { background: #ffc107; color: #212529; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
                button:hover { background: #e0a800; }
                .links { text-align: center; margin-top: 20px; }
                .links a { color: #007bff; text-decoration: none; }
                .error { color: red; margin-top: 10px; }
                .success { color: green; margin-top: 10px; }
            </style>
        </head>
        <body>
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña.</p>
            <form id="forgotForm" method="POST" action="/auth/forgot-password">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit">Enviar enlace de recuperación</button>
            </form>
            <div class="links">
                <a href="/auth/login">Volver al login</a>
            </div>
            <div id="message"></div>
            
            <script>
                document.getElementById("forgotForm").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    
                    try {
                        const response = await fetch("/auth/forgot-password", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(data)
                        });
                        
                        const result = await response.json();
                        const messageDiv = document.getElementById("message");
                        
                        if (result.success) {
                            messageDiv.innerHTML = "<div class=\"success\">" + result.message + "</div>";
                        } else {
                            messageDiv.innerHTML = "<div class=\"error\">" + result.message + "</div>";
                        }
                    } catch (error) {
                        document.getElementById("message").innerHTML = "<div class=\"error\">Error de conexión</div>";
                    }
                });
            </script>
        </body>
        </html>';
    }

    /**
     * Generar formulario de restablecimiento de contraseña
     */
    private function getResetPasswordForm(string $selector, string $token): string
    {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restablecer Contraseña</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
                button { background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
                button:hover { background: #c82333; }
                .links { text-align: center; margin-top: 20px; }
                .links a { color: #007bff; text-decoration: none; }
                .error { color: red; margin-top: 10px; }
                .success { color: green; margin-top: 10px; }
            </style>
        </head>
        <body>
            <h2>Restablecer Contraseña</h2>
            <form id="resetForm" method="POST" action="/auth/reset-password">
                <input type="hidden" name="selector" value="' . htmlspecialchars($selector) . '">
                <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                <div class="form-group">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small>Mínimo 8 caracteres</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </div>
                <button type="submit">Restablecer Contraseña</button>
            </form>
            <div class="links">
                <a href="/auth/login">Volver al login</a>
            </div>
            <div id="message"></div>
            
            <script>
                document.getElementById("resetForm").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    
                    if (data.password !== data.confirm_password) {
                        document.getElementById("message").innerHTML = "<div class=\"error\">Las contraseñas no coinciden</div>";
                        return;
                    }
                    
                    try {
                        const response = await fetch("/auth/reset-password", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(data)
                        });
                        
                        const result = await response.json();
                        const messageDiv = document.getElementById("message");
                        
                        if (result.success) {
                            messageDiv.innerHTML = "<div class=\"success\">" + result.message + "</div>";
                            setTimeout(() => { window.location.href = "/auth/login"; }, 2000);
                        } else {
                            messageDiv.innerHTML = "<div class=\"error\">" + result.message + "</div>";
                        }
                    } catch (error) {
                        document.getElementById("message").innerHTML = "<div class=\"error\">Error de conexión</div>";
                    }
                });
            </script>
        </body>
        </html>';
    }
    





}









