<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    $sql = "DELETE FROM Empleados WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_empleado);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/empleados.php?status=success&message=" . urlencode('Empleado eliminado exitosamente.'));
    } else {
        header("Location: ../../public/admin/empleados.php?status=error&message=" . urlencode('Error al eliminar: ' . $stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../../public/admin/empleados.php?status=error&message=ID no especificado.");
}
?>