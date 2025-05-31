<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stellar_homes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['idCliente'])) {
    $idCliente = $data['idCliente'];

    error_log("ID usuario recibido: " . $idCliente);

    $stmt = $conn->prepare("DELETE FROM clientes WHERE idCliente = ?");
    $stmt->bind_param("i", $idCliente);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cuenta eliminada con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la cuenta']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó el ID del usuario']);
}

$conn->close();
?>
