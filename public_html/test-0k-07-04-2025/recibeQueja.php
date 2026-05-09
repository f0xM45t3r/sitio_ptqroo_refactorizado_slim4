<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function mandaCorreo($datos){
    // Crea una instancia de PHPMailer
    $mail = new PHPMailer();
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP(); // Usa SMTP para enviar el correo
        $mail->Host = 'mail.ptqroo.org.mx'; // Servidor SMTP (ejemplo: smtp.gmail.com)
        $mail->SMTPAuth = true; // Habilita la autenticación SMTP
        $mail->Username = 'webmaster@ptqroo.org.mx'; // Tu correo electrónico
        $mail->Password = '8o);F630w!GL'; // Tu contraseña
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Puerto TCP (587 para TLS, 465 para SSL)
    
        // Remitente y destinatario
        $mail->setFrom('webmaster@ptqroo.org.mx', 'Sistema de recepción de quejas');
        $mail->addAddress('webmaster@ptqroo.org.mx', 'Nombre del Destinatario');
    
        // Contenido del correo
        $mail->isHTML(true); // Habilita HTML
        $mail->Subject = $datos["subject"];
        $mail->Body = "<h4>".$datos['lastname']." ".$datos['name']." </h4><br>";
        $mail->Body .= "Telefono: ".$datos['phone']."<br>";
        $mail->Body .= "Correo electrónico: ".$datos['mail']."<br>";
        $mail->Body .= $datos['message'];
        
        $mail->AltBody = 'Este es el cuerpo del correo en texto plano';
    
        $mail->send();
        echo 'Correo enviado con éxito';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    echo '<pre>'; // Para formatear la salida
    print_r($_POST);
    echo '</pre>';

    // Sanitización
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));
    $name = htmlspecialchars(trim($_POST['name']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $subject = htmlspecialchars(trim($_POST['subject']));

echo " <p> apellidos: $lastname</p>";
    // Validación
    $errores = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no es válido.';
    }

    if (empty($phone)) {
        $errores[] = 'El teléfono es obligatorio.';
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errores[] = 'El teléfono debe tener 10 dígitos numéricos.';
    }

    if (empty($message)) {
        $errores[] = 'El mensaje es obligatorio.';
    }
    if (empty($subject)) {
        $errores[] = 'El Tema es obligatorio.';
    }
    if (empty($name)) {
        $errores[] = 'El Nombre es obligatorio.';
    }
    if (empty($lastname)) {
        $errores[] = 'Los Apellidos son obligatorios.';
    }    

    // Si no hay errores, procesar los datos
    if (empty($errores)) {
        // Aquí puedes guardar los datos en una base de datos o enviar un correo electrónico
        $datos =array(
            "name" => $name,
            "lastname" => $lastname,
            
        
        );
        
        
        echo 'Datos recibidos correctamente.';
    } else {
        // Mostrar errores
        foreach ($errores as $error) {
            echo '<p>' . $error . '</p>';
        }
    }
        
}else{
    echo "error al enviar el formulario";
}
?>