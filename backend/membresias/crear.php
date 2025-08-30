<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? 0;
    $duracion_dias = $_POST['duracion_dias'] ?? 0;

    if (empty($tipo) || empty($precio) || empty($duracion_dias)) {
        $errorMessage = urlencode('Faltan campos obligatorios. Por favor, complete toda la información.');
        header("Location: ../../public/admin/agregar_membresia.php?status=error&message=" . $errorMessage);
        exit; 
    }

    $sql = "INSERT INTO Membresias (tipo, descripcion, precio, duracion_dias) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $tipo, $descripcion, $precio, $duracion_dias);
    
    if ($stmt->execute()) {
        $successMessage = urlencode('Tipo de membresía creada exitosamente.');
        header("Location: ../../public/admin/membresias.php?status=success&message=" . $successMessage);
    } else {
        $dbError = urlencode('Error al crear la membresía: ' . $stmt->error);
        header("Location: ../../public/admin/agregar_membresia.php?status=error&message=" . $dbError);
    }
    
    $stmt->close();
    $conn->close();
} else {

    header("Location: ../../public/admin/index.php");
    exit;
}
?>