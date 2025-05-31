<?php

session_start();
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$dbname = 'stellar_homes';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['id'])) {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE idCliente = :id");
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();
        $cliente_sesion = $stmt->fetchAll()[0];
    }


    echo json_encode($conn);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
