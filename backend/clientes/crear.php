<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $sexo = $_POST['sexo'] ?? 'Otro';
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? '';
    $estado = isset($_POST['estado']) ? 1 : 0; 

    if (empty($nombre) || empty($apellido) || empty($email)) {
        header("Location: ../../public/admin/clientes.php?status=error&message=" . urlencode('Faltan campos obligatorios.'));
        exit;
    }

    $sql = "INSERT INTO Clientes (nombre, apellido, fecha_nacimiento, sexo, telefono, email, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $apellido, $fecha_nacimiento, $sexo, $telefono, $email, $estado);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=" . urlencode('Cliente agregado exitosamente.'));
    } else {
        header("Location: ../../public/admin/clientes.php?status=error&message=" . urlencode('Error al agregar el cliente: ' . $stmt->error));
    }
    
    $stmt->close();
    $conn->close();
}
?>