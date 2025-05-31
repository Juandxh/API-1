<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['idInmobiliaria']) &&
        isset($data['NombreInmobiliaria']) &&
        isset($data['EmailInmobiliaria']) &&
        isset($data['Telefono']) &&
        isset($data['Direccion'])
    ) {

        $sql = "UPDATE inmobiliaria 
                SET NombreInmobiliaria = :NombreInmobiliaria, 
                    EmailInmobiliaria = :EmailInmobiliaria, 
                    Telefono = :Telefono, 
                    Direccion = :Direccion
                WHERE idInmobiliaria = :idInmobiliaria";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idInmobiliaria', $data['idInmobiliaria']);
        $stmt->bindParam(':NombreInmobiliaria', $data['NombreInmobiliaria']);
        $stmt->bindParam(':EmailInmobiliaria', $data['EmailInmobiliaria']);
        $stmt->bindParam(':Telefono', $data['Telefono']);
        $stmt->bindParam(':Direccion', $data['Direccion']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Inmobiliaria actualizada correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la inmobiliaria.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos enviados.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    http_response_code(500);
}
?>