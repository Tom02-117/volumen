<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$clase = $data['clase'] ?? '';
$dia = $data['dia'] ?? '';
$hora = $data['hora'] ?? '';
$orderID = $data['orderID'] ?? '';

$tipo_documento = $data['tipo_documento'] ?? '';
$numero_documento = $data['numero_documento'] ?? '';
$password = $data['password'] ?? '';

if (empty($clase) || empty($numero_documento) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos para procesar el pago.']);
    exit;
}

$stmt = $conn->prepare("SELECT id_cliente, password FROM clientes WHERE tipo_cedula = ? AND cedula = ?");
$stmt->bind_param("ss", $tipo_documento, $numero_documento);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cliente || !password_verify($password, $cliente['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas. No se pudo registrar la clase.']);
    exit;
}

$id_cliente = $cliente['id_cliente'];

$sql_insert = "INSERT INTO asistencia (id_cliente, clase, dia, hora, fecha) VALUES (?, ?, ?, ?, NOW())";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("isss", $id_cliente, $clase, $dia, $hora);

if ($stmt_insert->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Las credenciales son correctas, pero no se pudo registrar la asistencia.']);
}

$stmt_insert->close();
$conn->close();
?>
