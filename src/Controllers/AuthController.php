<?php

namespace App\Controllers;

use Slim\Views\Twig;
use Slim\Flash\Messages;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\AttemptCancelledException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Delight\Auth\UnknownUsernameException;
use Delight\Auth\AmbiguousUsernameException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\AuthError;
use Delight\Auth\NotLoggedInException;


class AuthController
{
    private Auth $auth;
    private Twig $view;
    private Messages $flash;
    private $errors ;

    public function __construct(Auth $auth, Twig $view, Messages $flash)
    {
        $this->auth = $auth;
        $this->view = $view;
        $this->flash = $flash;
    }

    // Método para agregar errores
    private function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;

    }    

    /**
     * Mostrar formulario de registro
     */
    public function showRegister(Request $request, Response $response): Response
    {
        if ($this->auth->isLoggedIn()) {
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        return $this->view->render($response, 'auth/register.twig');
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

            $this->flash->addMessage('success', 'Usuario registrado correctamente');
            
            if (!$this->auth->isLoggedIn()) {
                $this->flash->addMessage('info', 'Por favor verifica tu email');
            }

            return $response->withHeader('Location', '/dashboard')->withStatus(302);

        } catch (InvalidEmailException $e) {
            $this->flash->addMessage('error', 'Email inválido');
        } catch (InvalidPasswordException $e) {
            $this->flash->addMessage('error', 'Contraseña inválida (mínimo 8 caracteres)');
        } catch (UserAlreadyExistsException $e) {
            $this->flash->addMessage('error', 'El usuario ya existe');
        } catch (DuplicateUsernameException $e) {
            $this->flash->addMessage('error', 'El nombre de usuario ya está en uso');
        } catch (TooManyRequestsException $e) {
            $this->flash->addMessage('error', 'Demasiados intentos. Intenta más tarde');
        }

        return $response->withHeader('Location', '/auth/register')->withStatus(302);
    }

    /**
     * Mostrar formulario de login
     */
    public function showLogin(Request $request, Response $response): Response
    {
        if ($this->auth->isLoggedIn()) {
            return $response->withHeader('Location', '/admin/dashboard')->withStatus(302);
        }
          
        return $this->view->render($response, 'auth/login.twig', ['errors' => $this->errors]);
    }

    /**
     * Inicio de sesión
     */
    public function login(Request $request, Response $response): Response
    {      
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            if (empty($email) || empty($password)) {
                throw new \Exception('Email y contraseña son requeridos');
            }

            $this->auth->login($email, $password);
            $this->flash->addMessage('success', 'Inicio de sesión exitoso');

            return $response->withHeader('Location', '/admin/dashboard')->withStatus(302);


        } catch (InvalidEmailException $e) {
            $this->addError('error', 'Email inválido');
        } catch (InvalidPasswordException $e) {
            $this->addError('error', 'Contraseña incorrecta');
        } catch (EmailNotVerifiedException $e) {
            $this->addError('error', 'Email no verificado');
        } catch (TooManyRequestsException $e) {
            $this->addError('error', 'Demasiados intentos. Intenta más tarde');
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
                
        return $this->view->render($response, 'auth/login.twig', ['errors' => $this->errors]);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request, Response $response): Response
    {
        try {
            $this->auth->logOut();
            $this->flash->addMessage('success', 'Sesión cerrada correctamente');
        } catch (NotLoggedInException $e) {
            $this->flash->addMessage('error', 'No hay sesión activa');
        }

        return $response->withHeader('Location', '/cmspt')->withStatus(302);
    }

    /**
     * Mostrar formulario de contraseña olvidada
     */
    public function showForgotPassword(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/forgot-password.twig');
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
                $resetUrl = "https://tudominio.com/auth/reset-password?selector=$selector&token=$token";
                $this->sendPasswordResetEmail($email, $resetUrl);
            });

            $this->flash->addMessage('success', 'Email de restablecimiento enviado');
            return $response->withHeader('Location', '/auth/login')->withStatus(302);

        } catch (InvalidEmailException $e) {
            $this->flash->addMessage('error', 'Email inválido');
        } catch (EmailNotVerifiedException $e) {
            $this->flash->addMessage('error', 'Email no verificado');
        } catch (TooManyRequestsException $e) {
            $this->flash->addMessage('error', 'Demasiados intentos. Intenta más tarde');
        }

        return $response->withHeader('Location', '/auth/forgot-password')->withStatus(302);
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
            $this->flash->addMessage('error', 'Token de restablecimiento inválido');
            return $response->withHeader('Location', '/auth/forgot-password')->withStatus(302);
        }

        return $this->view->render($response, 'auth/reset-password.twig', [
            'selector' => $selector,
            'token' => $token
        ]);
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
        $confirmPassword = $data['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $this->flash->addMessage('error', 'Las contraseñas no coinciden');
            return $response->withHeader('Location', "/auth/reset-password?selector=$selector&token=$token")->withStatus(302);
        }

        try {
            $this->auth->resetPassword($selector, $token, $password);
            $this->flash->addMessage('success', 'Contraseña restablecida correctamente');
            return $response->withHeader('Location', '/auth/login')->withStatus(302);

        } catch (InvalidSelectorTokenPairException $e) {
            $this->flash->addMessage('error', 'Token de restablecimiento inválido');
        } catch (TokenExpiredException $e) {
            $this->flash->addMessage('error', 'Token de restablecimiento expirado');
        } catch (InvalidPasswordException $e) {
            $this->flash->addMessage('error', 'Contraseña inválida (mínimo 8 caracteres)');
        } catch (TooManyRequestsException $e) {
            $this->flash->addMessage('error', 'Demasiados intentos. Intenta más tarde');
        }

        return $response->withHeader('Location', "/auth/reset-password?selector=$selector&token=$token")->withStatus(302);
    }

    /**
     * Métodos auxiliares
     */
    private function sendVerificationEmail(string $email, string $verificationUrl): void
    {
        // Implementación real del envío de email
    }

    private function sendPasswordResetEmail(string $email, string $resetUrl): void
    {
        // Implementación real del envío de email
    }
}