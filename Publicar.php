<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $Nombre = $conn->real_escape_string($_POST['Nombre']);
    $Descripcion = $conn->real_escape_string($_POST['descripcion']);
    $localidad = $conn->real_escape_string($_POST['localidad']);
    $Direccion = $conn->real_escape_string($_POST['direccion']);
    $NumCont = $conn->real_escape_string($_POST['numCont']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $FechaPubli = $conn->real_escape_string($_POST['fechaPubli']);
    $transaccion_idtransaccion = $conn->real_escape_string($_POST['transaccion_idtransaccion']);
    $estado_id_estado = $conn->real_escape_string($_POST['estado_id_estado']);
    $tipo_idtipo = $conn->real_escape_string($_POST['tipo_idtipo']);
    $inmobiliaria_idInmobiliaria = $conn->real_escape_string($_POST['inmobiliaria_idInmobiliaria']);

   
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen'];
        $imagen_nombre = $imagen['name'];
        $imagen_tmp = $imagen['tmp_name'];
        $imagen_destino = 'uploads/' . uniqid() . '-' . $imagen_nombre;  

       
        $imagen_url = 'http://localhost/API/' . $imagen_destino;

        $imageFileType = strtolower(pathinfo($imagen_destino, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
        
                
                $sql = "INSERT INTO inmueble (Nombre, Descripcion, localidad, Direccion, NumCont, precio, FechaPubli, transaccion_idtransaccion, estado_id_estado, tipo_idtipo, inmobiliaria_idInmobiliaria, imagen)
                        VALUES ('$Nombre', '$Descripcion', '$localidad', '$Direccion', '$NumCont', '$precio', '$FechaPubli', '$transaccion_idtransaccion', '$estado_id_estado', '$tipo_idtipo', '$inmobiliaria_idInmobiliaria', '$imagen_url')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(['success' => true, 'message' => 'Publicación exitosa']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al insertar en la base de datos']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al subir la imagen']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Solo se permiten imágenes en formato JPG, JPEG, PNG']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Imagen no proporcionada o con error']);
    }
}

$conn->close();
?>