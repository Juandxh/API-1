<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');

require('./conexion.php');

require(__DIR__ . '/PHPMailer/src/Exception.php');
require(__DIR__ . '/PHPMailer/src/PHPMailer.php');
require(__DIR__ . '/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $Email = $data['email'];

    $sql = "SELECT idCliente FROM clientes WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $Email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $codigo = bin2hex(random_bytes(50));

        $sql = "INSERT INTO password_resets (clientes_idCliente, CorreoElectronico, codigo) VALUES 
        (:idCliente, :email, :codigo)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":idCliente", $result['idCliente']);
        $stmt->bindValue(":email", $Email);
        $stmt->bindValue(":codigo", $codigo);
        $stmt->execute();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'stellarhomes777@gmail.com';
        $mail->Password = 'zptq kwfm mikp uuwp';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $resetLink = "http://localhost:3000/cambioContra?codigo=" . urlencode($codigo);

        $subject = "Restablecer tu contraseña";
        $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: " . $resetLink;

        $mail->setFrom('stellarhomes777@gmail.com', 'Stellar Homes');
        $mail->addAddress($Email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->CharSet = 'UTF-8';

        try {
            $mail->send();
            echo json_encode([
                'status' => 'success',
                'message' => 'Hemos enviado un enlace para restablecer tu contraseña a tu correo electrónico.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Hubo un error al enviar el correo. Inténtalo de nuevo.',
                'error' => $mail->ErrorInfo
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró ninguna cuenta con ese correo electrónico.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido.'
    ]);
}
