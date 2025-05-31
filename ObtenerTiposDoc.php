<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'stellar_homes';  
$username = 'root';   
$password = '';  

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT id_tipoDoc FROM tipo_doc");
    $tiposDoc = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tiposDoc);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
