<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit;
}

require_once '../config/database.php';

header('Content-Type: application/json');

$query = $_GET['query'] ?? '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

$searchTerm = "%" . strtolower($query) . "%";

$sql = "SELECT id_cliente, nombre, apellido 
        FROM clientes 
        WHERE (LOWER(CONCAT(nombre, ' ', apellido)) LIKE ? OR cedula LIKE ?) AND estado = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$clientes = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

echo json_encode($clientes);
?>