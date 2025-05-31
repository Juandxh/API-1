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
        isset($data['idCliente']) &&
        isset($data['Nombre']) &&
        isset($data['Apellido']) &&
        isset($data['Email']) 
    ) {

        $sql = "UPDATE clientes 
                SET Nombre = :Nombre, 
                    Apellido = :Apellido, 
                    Email = :Email 
                WHERE idCliente = :idCliente";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idCliente', $data['idCliente']);
        $stmt->bindParam(':Nombre', $data['Nombre']);
        $stmt->bindParam(':Apellido', $data['Apellido']);
        $stmt->bindParam(':Email', $data['Email']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'usuario actualizado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos enviados.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    http_response_code(500);
}
?>