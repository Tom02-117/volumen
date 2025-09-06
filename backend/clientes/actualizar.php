<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') { die("Acceso denegado."); }
include '../config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? null;
    $estado = $_POST['estado'] ?? 1;
    $password = $_POST['password'] ?? '';

    if (empty($id_cliente) || empty($nombre) || empty($email)) {
        header("Location: ../../public/admin/editar_cliente.php?id={$id_cliente}&status=error&message=Faltan campos."); exit;
    }

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE Clientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, estado = ?, password = ? WHERE id_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $nombre, $apellido, $email, $telefono, $estado, $password_hash, $id_cliente);
    } else {
        $sql = "UPDATE Clientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, estado = ? WHERE id_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $nombre, $apellido, $email, $telefono, $estado, $id_cliente);
    }

    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=Cliente actualizado.");
    } else {
        header("Location: ../../public/admin/editar_cliente.php?id={$id_cliente}&status=error&message=" . urlencode($stmt->error));
    }
    $stmt->close();
    $conn->close();
}
?>