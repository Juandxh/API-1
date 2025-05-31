<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
session_start();
header('Content-Type: application/json'); 

$host = 'localhost';
$dbname = 'stellar_homes';  
$username = 'root';   
$password = '';  

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['id'])) {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE idCliente = :id_i");
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();
        $sesionInmobiliaria = $stmt->fetchAll()[0];
    }

    $data = json_decode(file_get_contents("php://input"), true);

    if (
        empty($data['Nombre']) ||
        empty($data['Apellido']) ||
        empty($data['FechNaci']) ||
        empty($data['Email']) ||
        empty($data['ContrasenaCliente']) ||
        empty($data['tipo_doc_id_tipoDoc'])
    ) {
        echo json_encode(["error" => "Todos los campos son obligatorios."]);
        exit();
    }

    $nombre = $data['Nombre'];
    $apellido = $data['Apellido'];
    $fechNaci = $data['FechNaci'];
    $email = $data['Email'];
    $contrasena = $data['ContrasenaCliente'];
    $tipoDocId = $data['tipo_doc_id_tipoDoc'];

    $contrasenaEncriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO clientes (Nombre, Apellido, FechaNaci, Email, ContrasenaCliente, tipo_doc_id_tipoDoc) 
                            VALUES (:Nombre, :Apellido, :FechaNaci, :Email, :ContrasenaCliente, :tipo_doc_id_tipoDoc)");

    $stmt->bindParam(':Nombre', $nombre);
    $stmt->bindParam(':Apellido', $apellido);
    $stmt->bindParam(':FechaNaci', $fechNaci);
    $stmt->bindParam(':Email', $email);
    $stmt->bindParam(':ContrasenaCliente', $contrasenaEncriptada);
    $stmt->bindParam(':tipo_doc_id_tipoDoc', $tipoDocId);

    $stmt->execute();

    echo json_encode(["message" => "Cliente creado correctamente"]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
