<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['idInmueble'])) {
        $idInmueble = $_GET['idInmueble'];

        $stmt = $conn->prepare("SELECT *, CASE estado_id_estado WHEN 1 THEN 'disponible' WHEN 2 THEN 'no disponible' END AS estado_desc FROM inmueble WHERE idInmueble = :idInmueble");
        $stmt->bindParam(':idInmueble', $idInmueble);
        $stmt->execute();

        $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($inmueble) {
            echo json_encode($inmueble);
        } else {
            echo json_encode(['error' => 'Inmueble no encontrado']);
        }
    } else {
        echo json_encode(['error' => 'ID de inmueble no proporcionado']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
}
?>
