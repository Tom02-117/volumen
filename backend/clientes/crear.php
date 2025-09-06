<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') { die("Acceso denegado."); }
include '../config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $telefono = $_POST['telefono'] ?? null;

    if (empty($nombre) || empty($email) || empty($password)) {
        header("Location: ../../public/admin/agregar_cliente.php?status=error&message=Nombre, email y contraseña son obligatorios."); exit;
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nombre, apellido, email, password, telefono) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $password_hash, $telefono);
    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=Cliente creado exitosamente.");
    } else {
        header("Location: ../../public/admin/agregar_cliente.php?status=error&message=" . urlencode($stmt->error));
    }
    $stmt->close();
    $conn->close();
}
?>