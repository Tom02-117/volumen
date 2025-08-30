<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $sexo = $_POST['sexo'] ?? 'Otro';
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? '';
    $estado = isset($_POST['estado']) ? 1 : 0;

    if (empty($id_cliente) || empty($nombre) || empty($apellido) || empty($email)) {
        header("Location: ../../public/admin/clientes.php?status=error&message=" . urlencode('Faltan datos obligatorios.'));
        exit;
    }

    $sql = "UPDATE Clientes SET nombre = ?, apellido = ?, fecha_nacimiento = ?, sexo = ?, telefono = ?, email = ?, estado = ? WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssii", $nombre, $apellido, $fecha_nacimiento, $sexo, $telefono, $email, $estado, $id_cliente);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=" . urlencode('Cliente actualizado exitosamente.'));
    } else {
        header("Location: ../../public/admin/clientes.php?status=error&message=" . urlencode('Error al actualizar el cliente: ' . $stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>