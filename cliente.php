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
    if (isset($_GET['idCliente'])) {
        $idCliente = $_GET['idCliente'];

        $stmt = $conn->prepare("SELECT idCliente, Nombre, Apellido, Email 
        FROM clientes
         WHERE idCliente = :idCliente");
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['error' => 'usuario no encontrado']);
        }
    } else {
        echo json_encode(['error' => 'ID de usuario no proporcionado']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
}
?>