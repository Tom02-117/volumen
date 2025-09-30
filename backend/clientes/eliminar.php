<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador')  { die("Acceso denegado."); }
include '../config/database.php';
if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $sql = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=Cliente eliminado.");
    } else {
        header("Location: ../../public/admin/clientes.php?status=error&message=Error al eliminar.");
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../../public/admin/clientes.php?status=error&message=ID no especificado.");
}
?>