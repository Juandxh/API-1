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
    die("Conexión fallida: " . $conn->connect_error);
}


$data = json_decode(file_get_contents("php://input"), true);


if (isset($data['idInmueble'])) {
    $idInmueble = $data['idInmueble'];

    
    error_log("ID Inmueble recibido: " . $idInmueble);

    
    $stmt = $conn->prepare("DELETE FROM inmueble WHERE idInmueble = ?");
    $stmt->bind_param("i", $idInmueble); 

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Inmueble eliminado con éxito']);
    } else {
      
        echo json_encode(['message' => 'Error al eliminar inmueble', 'error' => $conn->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['message' => 'No se proporcionó el ID del inmueble']);
}

$conn->close();
?>
