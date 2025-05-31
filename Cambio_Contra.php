<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once(__DIR__ . '/conexion_contra.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight CORS response
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener datos del JSON body
        $data = json_decode(file_get_contents("php://input"), true);
        $codigo = $data['codigo'] ?? null;
        $new_password = $data['ContrasenaCliente'] ?? null;
        $confirm_password = $data['ContrasenaClienteConfirm'] ?? null;

        if (!$codigo || !$new_password || !$confirm_password) {
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos requeridos'
            ]);
            exit;
        }

        if ($new_password !== $confirm_password) {
            echo json_encode([
                'success' => false,
                'message' => 'Las contraseñas no coinciden'
            ]);
            exit;
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Verificar código en la base de datos
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE codigo = :codigo");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'El enlace de restablecimiento es inválido o ha expirado'
            ]);
            exit;
        }

        $email = $result['CorreoElectronico'];

        // Actualizar la contraseña del usuario
        $stmt = $conn->prepare("UPDATE clientes SET ContrasenaCliente = :password WHERE Email = :email");
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Eliminar el código de recuperación
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE codigo = :codigo");
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo actualizar la contraseña. Intenta de nuevo.'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error de servidor: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
