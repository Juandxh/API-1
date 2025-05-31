<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
header('Access-Control-Allow-Credentials: true'); 
$servername = "localhost";
$username = "root";
$password = "";
$database = "stellar_homes";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 

    $query_tipos = "SELECT idtipo, descripcion FROM tipo";
    $stmt_tipos = $conn->prepare($query_tipos);
    $stmt_tipos->execute();
    $tipos = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tipos);
    

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>