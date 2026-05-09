<?php

use Slim\Flash\Messages;

/**
 * Agrega un mensaje flash de forma simple
 *
 * @param Messages $flash Instancia de Slim\Flash\Messages
 * @param string $type Tipo del mensaje ('success', 'error', etc.)
 * @param string $message Contenido del mensaje
 */
function flashMessage(Messages $flash, string $type, string $message): void
{
    $flash->addMessage($type, $message);
}