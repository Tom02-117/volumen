<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    http_response_code(403);
    die("Acceso denegado.");
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_SESSION['user_id'];
    $id_membresia = $_POST['id_membresia'] ?? 0;

    if (!$id_membresia) {
        header("Location: ../../public/cliente/membresias.php?compra=error");
        exit;
    }

    $stmt_plan = $conn->prepare("SELECT duracion_dias FROM membresias WHERE id_membresia = ?");
    $stmt_plan->bind_param("i", $id_membresia);
    $stmt_plan->execute();
    $plan = $stmt_plan->get_result()->fetch_assoc();
    
    if (!$plan) {
        header("Location: ../../public/cliente/membresias.php?compra=error");
        exit;
    }
    $duracion_dias = $plan['duracion_dias'];
    $stmt_plan->close();

    $sql_update = "UPDATE clientes_membresias SET estado = 'Vencida' WHERE id_cliente = ? AND estado = 'Activa'";
    $stmt_update = $conn->prepare($sql_update);
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

    if ($stmt_insert->execute()) {
        header("Location: ../../public/cliente/panel.php?compra=exito");
    } else {
        header("Location: ../../public/cliente/membresias.php?compra=error");
    }
    $stmt_insert->close();
    $conn->close();
} else {
    header("Location: ../../public/cliente/membresias.php");
    exit;
}
?>