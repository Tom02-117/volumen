<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador') {
    die("Acceso denegado. Se requiere ser Administrador.");
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_membresia = $_POST['id_membresia'] ?? 0;
    $tipo = $_POST['tipo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? 0;
    $duracion_dias = $_POST['duracion_dias'] ?? 0;

    if (empty($id_membresia) || empty($tipo) || empty($precio) || empty($duracion_dias)) {
        header("Location: ../../public/admin/membresias.php?status=error&message=Faltan campos obligatorios.");
        exit;
    }

    $sql = "UPDATE membresias SET tipo = ?, descripcion = ?, precio = ?, duracion_dias = ? WHERE id_membresia = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssdii", $tipo, $descripcion, $precio, $duracion_dias, $id_membresia);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/membresias.php?status=success&message=Plan de membresía actualizado exitosamente.");
    } else {
        header("Location: ../../public/admin/membresias.php?status=error&message=" . urlencode($stmt->error));
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../../public/admin/membresias.php");
    exit;
}
?>