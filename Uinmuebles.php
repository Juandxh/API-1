<?php  
header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json');

$servername = "localhost"; 
$username = "root";       
$password = "";           
$dbname = "stellar_homes"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}
$sql = "SELECT * FROM inmueble WHERE estado_id_estado = 1"; 


$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    exit();
}
$inmuebles = [];

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
        $inmuebles[] = $row;
    }
} else {
    $inmuebles = ['message' => 'No hay inmuebles disponibles.'];
}


echo json_encode($inmuebles);

$conn->close();
?>
