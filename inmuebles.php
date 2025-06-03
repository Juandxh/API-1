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
    e.Descripcion AS transaccion
FROM inmueble i
JOIN tipo t ON i.tipo_idtipo = t.idtipo
JOIN transaccion e ON i.transaccion_idtransaccion = e.idtransaccion
WHERE 1 = 1 AND estado_id_estado = 1
";

$params = [];
$types = "";

// Filtro por tipo
if (!empty($_GET['tipo'])) {
    $query .= " AND t.Descripcion LIKE ?";
    $params[] = "%" . $_GET['tipo'] . "%";
    $types .= "s";
}

// Filtro por transacción
if (!empty($_GET['transaccion'])) {
    $query .= " AND e.Descripcion LIKE ?";
    $params[] = "%" . $_GET['transaccion'] . "%";
    $types .= "s";
}

// Filtro por localidad
if (!empty($_GET['localidad'])) {
    $query .= " AND i.localidad LIKE ?";
    $params[] = "%" . $_GET['localidad'] . "%";
    $types .= "s";
}

// Filtro por rango de precios
if (!empty($_GET['precio_min']) && !empty($_GET['precio_max'])) {
    $query .= " AND i.precio BETWEEN ? AND ?";
    $params[] = (int)$_GET['precio_min'];
    $params[] = (int)$_GET['precio_max'];
    $types .= "ii";
}

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$inmuebles = [];
while ($row = $result->fetch_assoc()) {
    $inmuebles[] = $row;
}

echo json_encode($inmuebles);
$conn->close();
?>
