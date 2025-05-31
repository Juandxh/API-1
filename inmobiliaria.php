<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT idInmobiliaria, NombreInmobiliaria, EmailInmobiliaria, Telefono, Direccion 
            FROM inmobiliaria 
            WHERE idInmobiliaria = 1";
    $stmt = $conn->query($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode($data); 
    } else {
        echo json_encode(['error' => 'Inmobiliaria no encontrada']);
        http_response_code(404);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    http_response_code(500);
}
?>
