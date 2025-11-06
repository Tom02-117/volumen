<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador')  { die("Acceso denegado."); }
include '../config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $tipo_cedula = $_POST['tipo_cedula'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $fecha_nacimieno = $_POST['fecha_nacimiento'] ?? '';
    $password = $_POST['password'] ?? '';
    $telefono = $_POST['telefono'] ?? null;

    if (empty($nombre) || empty($email) || empty($password) || empty($cedula)) {
        header("Location: ../../public/admin/agregar_cliente.php?status=error&message=Nombre, email y contraseña son obligatorios."); exit;
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Clientes (nombre, apellido, email, sexo, tipo_cedula, cedula, fecha_nacimiento, password, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nombre, $apellido, $email, $sexo, $tipo_cedula, $cedula, $fecha_nacimieno, $password_hash, $telefono);
    if ($stmt->execute()) {
        header("Location: ../../public/admin/clientes.php?status=success&message=Cliente creado exitosamente.");
    } else {
        header("Location: ../../public/admin/agregar_cliente.php?status=error&message=" . urlencode($stmt->error));
    }
    $stmt->close();
    $conn->close();
}
?>