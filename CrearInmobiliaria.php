<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['id_i'])) {
        $stmt = $conn->prepare("SELECT * FROM inmobiliaria WHERE idInmobiliaria = :id_i");
        $stmt->bindParam(':id_i', $_SESSION['id_i']);
        $stmt->execute();
        $sesionInmobiliaria = $stmt->fetchAll()[0];}

    $data = json_decode(file_get_contents("php://input"), true);

    $NombreInmobiliaria = $data['NombreInmobiliaria'];
    $CorreoInmobiliaria = $data['CorreoInmobiliaria'];
    $TelefonoInmobiliaria = $data['TelefonoInmobiliaria'];
    $Direccion = $data['Direccion'];
    $ContrasenaInmobiliaria = $data['ContrasenaInmobiliaria'];

    $ContrasenaEncriptada = password_hash($ContrasenaInmobiliaria, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("
        INSERT INTO inmobiliaria (NombreInmobiliaria, EmailInmobiliaria, Telefono, Direccion, ContrasenaInmobiliaria) 
        VALUES (:NombreInmobiliaria, :CorreoInmobiliaria, :TelefonoInmobiliaria, :Direccion, :ContrasenaInmobiliaria)");

    $stmt->bindParam(':NombreInmobiliaria', $NombreInmobiliaria);
    $stmt->bindParam(':CorreoInmobiliaria', $CorreoInmobiliaria);
    $stmt->bindParam(':TelefonoInmobiliaria', $TelefonoInmobiliaria);
    $stmt->bindParam(':Direccion', $Direccion);
    $stmt->bindParam(':ContrasenaInmobiliaria', $ContrasenaEncriptada);

    $stmt->execute();

    $last_id = $conn->lastInsertId();

    $_SESSION['id_i'] = $last_id;

    echo json_encode(["success" => true, "message" => "Inmobiliaria registrada con éxito."]);
} catch (PDOException $e) {

    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
