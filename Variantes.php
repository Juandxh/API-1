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

    $query_transacciones = "SELECT idtransaccion, descripcion FROM transaccion";
    $stmt_transacciones = $conn->prepare($query_transacciones);
    $stmt_transacciones->execute();
    $transacciones = $stmt_transacciones->fetchAll(PDO::FETCH_ASSOC);    
    
echo json_encode( $transacciones);


} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
