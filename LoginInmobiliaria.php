<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

$correoValido = 'ME1234@gmail.com';
$contrasenaValida = 'ME1234';
$nombreInmobiliaria = 'Inmobiliaria ME';  

session_start();

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$loginType = $data['loginType'] ?? '';

if ($loginType !== "inmobiliaria") {
    http_response_code(400);
    echo json_encode(["error" => "Tipo de inicio de sesión no válido."]);
    exit;
}

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["error" => "Correo y contraseña son obligatorios."]);
    exit;
}

if ($email === $correoValido && $password === $contrasenaValida) {
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $nombreInmobiliaria;  

    echo json_encode([
        "success" => true,
        "message" => "Inicio de sesión exitoso.",
        "user_email" => $_SESSION['user_email'],
        "user_name" => $_SESSION['user_name']  
    ]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Correo o contraseña incorrectos."]);
}
?>
