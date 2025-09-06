<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') { die("Acceso denegado."); }
include '../config/database.php';

$id_empleado = $_GET['id'] ?? 0;

if ($id_empleado == $_SESSION['user_id']) {
    header("Location: ../../public/admin/empleados.php?status=error&message=No puedes eliminar tu propia cuenta.");
    exit;
}

if ($id_empleado) {
    $sql = "DELETE FROM Empleados WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $stmt->close();
    header("Location: ../../public/admin/empleados.php?status=success&message=Empleado eliminado.");
} else {
    header("Location: ../../public/admin/empleados.php?status=error&message=ID no válido.");
}
$conn->close();
?>