<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Validación de campos
        if (
            isset($_POST['idInmueble'], $_POST['Nombre'], $_POST['Descripcion'], $_POST['localidad'],
                  $_POST['precio'], $_POST['FechaPubli'], $_POST['estado_id_estado'],
                  $_POST['tipo_idtipo'], $_POST['transaccion_idtransaccion'])
        ) {

            $idInmueble = $_POST['idInmueble'];
            $Nombre = $_POST['Nombre'];
            $Descripcion = $_POST['Descripcion'];
            $localidad = $_POST['localidad'];
            $precio = $_POST['precio'];
            $FechaPubli = $_POST['FechaPubli'];
            $estado_id_estado = $_POST['estado_id_estado'];
            $tipo_idtipo = $_POST['tipo_idtipo'];
            $transaccion_idtransaccion = $_POST['transaccion_idtransaccion'];

            $imagenNombre = null;

            $imagen_url = null;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $imagen = $_FILES['imagen'];
                $imagen_nombre = uniqid() . '-' . $imagen['name'];
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagen_destino = $uploadDir . $imagen_nombre;

                if (move_uploaded_file($imagen['tmp_name'], $imagen_destino)) {
                    $imagen_url = 'http://localhost/API/' . $imagen_destino;
                }
            }

            // Construcción del SQL dinámicamente
            $sql = "UPDATE inmueble SET 
                    Nombre = :Nombre,
                    Descripcion = :Descripcion,
                    localidad = :localidad,
                    precio = :precio,
                    FechaPubli = :FechaPubli,
                    estado_id_estado = :estado_id_estado,
                    tipo_idtipo = :tipo_idtipo,
                    transaccion_idtransaccion = :transaccion_idtransaccion";

            if ($imagen_url) {
            $sql .= ", imagen = :imagen"; }




            $sql .= " WHERE idInmueble = :idInmueble";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':localidad', $localidad);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':FechaPubli', $FechaPubli);
            $stmt->bindParam(':estado_id_estado', $estado_id_estado);
            $stmt->bindParam(':tipo_idtipo', $tipo_idtipo);
            $stmt->bindParam(':transaccion_idtransaccion', $transaccion_idtransaccion);
            $stmt->bindParam(':idInmueble', $idInmueble);

        if ($imagen_url) {
            $stmt->bindParam(':imagen', $imagen_url);
        }
            $stmt->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Faltan datos para la actualización']);
        }
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
}
?>
