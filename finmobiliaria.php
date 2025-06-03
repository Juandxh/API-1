<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$user = "root";
$password = "";
$dbname = "stellar_homes";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Modo 1: Retornar opciones para filtros
if (isset($_GET['action']) && $_GET['action'] === 'opciones') {
    $res = [];

    $tipos = $conn->query("SELECT Descripcion FROM tipo");
    $res['tipos'] = [];
    while ($row = $tipos->fetch_assoc()) {
        $res['tipos'][] = $row['Descripcion'];
    }

    $trans = $conn->query("SELECT Descripcion FROM transaccion");
    $res['transacciones'] = [];
    while ($row = $trans->fetch_assoc()) {
        $res['transacciones'][] = $row['Descripcion'];
    }

    $estados = $conn->query("SELECT Descripcion FROM estado");
    $res['estados'] = [];
    while ($row = $estados->fetch_assoc()) {
        $res['estados'][] = $row['Descripcion'];
    }

    echo json_encode($res);
    $conn->close();
    exit;
}

// Modo 2: Retornar inmuebles filtrados si hay filtros

$tipo = $_GET['tipo'] ?? '';
$transaccion = $_GET['transaccion'] ?? '';
$estado = $_GET['estado'] ?? '';

$query = "
SELECT 
    i.idInmueble,
    i.Nombre,
    i.imagen,
    i.Descripcion,
    i.localidad,
    i.precio,
    i.FechaPubli,
    t.Descripcion AS tipo, 
    e.Descripcion AS transaccion,
    p.Descripcion AS estado
FROM inmueble i
JOIN tipo t ON i.tipo_idtipo = t.idtipo
JOIN transaccion e ON i.transaccion_idtransaccion = e.idtransaccion
JOIN estado p ON i.estado_id_estado = p.id_estado
WHERE 1=1
";

// Agregar filtros dinámicamente
if (!empty($tipo)) {
    $query .= " AND t.Descripcion = '" . $conn->real_escape_string($tipo) . "'";
}
if (!empty($transaccion)) {
    $query .= " AND e.Descripcion = '" . $conn->real_escape_string($transaccion) . "'";
}
if (!empty($estado)) {
    $query .= " AND p.Descripcion = '" . $conn->real_escape_string($estado) . "'";
}

$result = $conn->query($query);

$inmuebles = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $inmuebles[] = $row;
    }
    echo json_encode($inmuebles);
} else {
    echo json_encode(["error" => "Error al ejecutar la consulta: " . $conn->error]);
}

$conn->close();
?>
