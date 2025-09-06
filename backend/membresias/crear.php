<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') { die("Acceso denegado."); }
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? 0;
    $duracion_dias = $_POST['duracion_dias'] ?? 0;

    if (empty($tipo) || empty($precio) || empty($duracion_dias)) {
        header("Location: ../../public/admin/agregar_membresia.php?status=error&message=Nombre, precio y duración son obligatorios.");
        exit;
    }

    $sql = "INSERT INTO Membresias (tipo, descripcion, precio, duracion_dias) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $tipo, $descripcion, $precio, $duracion_dias);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/membresias.php?status=success&message=Nuevo plan creado exitosamente.");
    } else {
        header("Location: ../../public/admin/agregar_membresia.php?status=error&message=Error al crear el plan.");
    }
    $stmt->close();
    $conn->close();
}
?>