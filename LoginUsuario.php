<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json'); 

$host = 'localhost';
$dbname = 'stellar_homes';  
$username = 'root';   
$password = '';  

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['email']) || empty($data['password'])) {
        echo json_encode(["error" => "Correo y contraseña son obligatorios."]);
        exit();
    }

    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['ContrasenaCliente'])) {
        
        session_start();
        $_SESSION['id'] = $user['idCliente'];

        echo json_encode(["message" => "Inicio de sesión exitoso", "userId" => $user['idCliente']]);
    } else {
        echo json_encode(["error" => "Correo o contraseña incorrectos."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
