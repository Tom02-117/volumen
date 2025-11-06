<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Acceso denegado.']);
    exit;
}
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_cliente = $_SESSION['user_id'];
$item_type = $data['item_type'] ?? null;

if ($item_type === 'membresia') {
    $id_membresia = $data['id_membresia'] ?? 0;
    if (!$id_membresia) { echo json_encode(['status' => 'error', 'message' => 'ID de membresía no válido.']); exit; }

    $stmt_plan = $conn->prepare("SELECT duracion_dias FROM membresias WHERE id_membresia = ?");
    $stmt_plan->bind_param("i", $id_membresia);
    $stmt_plan->execute();
    $plan = $stmt_plan->get_result()->fetch_assoc();
    if (!$plan) { echo json_encode(['status' => 'error', 'message' => 'Plan no encontrado.']); exit; }
    $duracion_dias = $plan['duracion_dias'];
    $stmt_plan->close();

    $conn->begin_transaction();
    try {
        $stmt_update = $conn->prepare("UPDATE clientes_membresias SET estado = 'Vencida' WHERE id_cliente = ? AND estado = 'Activa'");
        $stmt_update->bind_param("i", $id_cliente);
        $stmt_update->execute();
        $stmt_update->close();

        $fecha_inicio = date('Y-m-d');
        $fecha_fin_obj = new DateTime($fecha_inicio);
        $fecha_fin_obj->modify("+" . $duracion_dias . " days");
        $fecha_fin = $fecha_fin_obj->format('Y-m-d');

        $sql_insert = "INSERT INTO clientes_membresias (id_cliente, id_membresia, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, 'Activa')";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiss", $id_cliente, $id_membresia, $fecha_inicio, $fecha_fin);
        $stmt_insert->execute();
        $stmt_insert->close();
        
        $conn->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Error en la transacción.']);
    }

} elseif ($item_type === 'clase') {
    $clase = $data['clase'] ?? '';
    $dia = $data['dia'] ?? '';
    $hora = $data['hora'] ?? '';

    if (empty($clase) || empty($dia) || empty($hora)) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos de la clase.']);
        exit;
    }
    
    $sql_insert = "INSERT INTO asistencia (id_cliente, clase, dia, hora, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("isss", $id_cliente, $clase, $dia, $hora);
    
    if ($stmt_insert->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar la asistencia.']);
    }
    $stmt_insert->close();
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Tipo de compra no válido.']);
}

$conn->close();
?>