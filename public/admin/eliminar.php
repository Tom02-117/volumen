<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "DELETE FROM Clientes WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=" . urlencode('Cliente eliminado exitosamente.'));
    } else {
        header("Location: ../../public/admin/clientes.php?status=error&message=" . urlencode('Error al eliminar el cliente: ' . $stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../../public/admin/clientes.php?status=error&message=ID de cliente no especificado.");
}
?>