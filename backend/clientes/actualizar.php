<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador') { 
    die("Acceso denegado."); 
}
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $tipo_cedula = $_POST['tipo_cedula'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $telefono = $_POST['telefono'] ?? null;
    $estado = $_POST['estado'] ?? 1;
    $password = $_POST['password'] ?? '';

    if (empty($id_cliente) || empty($nombre) || empty($email)) {
        header("Location: ../../public/admin/editar_cliente.php?id={$id_cliente}&status=error&message=Faltan campos."); 
        exit;
    }

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE clientes SET nombre = ?, apellido = ?, email = ?, tipo_cedula = ?, cedula = ?, telefono = ?, estado = ?, password = ? WHERE id_cliente = ?";
        $stmt = $conn->prepare($sql);
        
        // s (nombre), s (apellido), s (email), s (tipo_cedula), s (cedula), s (telefono), i (estado), s (password_hash), i (id_cliente)
        $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $tipo_cedula, $cedula, $telefono, $estado, $password_hash, $id_cliente);

    } else {
        $sql = "UPDATE clientes SET nombre = ?, apellido = ?, email = ?, tipo_cedula = ?, cedula = ?, telefono = ?, estado = ? WHERE id_cliente = ?";
        $stmt = $conn->prepare($sql);

        // s (nombre), s (apellido), s (email), s (tipo_cedula), s (cedula), s (telefono), i (estado), i (id_cliente)
        $stmt->bind_param("ssssssii", $nombre, $apellido, $email, $tipo_cedula, $cedula, $telefono, $estado, $id_cliente);
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