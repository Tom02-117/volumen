<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador') {
    die("Acceso denegado.");
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $tipo_cedula = $_POST['tipo_cedula'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $puesto = $_POST['puesto'] ?? '';
    $password = $_POST['password'] ?? '';
    

    if (empty($nombre) || empty($cedula) || empty($password) || empty($puesto)) {
        header("Location: ../../public/admin/agregar_empleado.php?status=error&message=Todos los campos son obligatorios.");
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Empleados (nombre, apellido, email, tipo_cedula, cedula, telefono, puesto, password) VALUES (?, ?, ?, ?, ? ,? ,? ,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $nombre, $apellido, $email, $tipo_cedula, $cedula, $telefono, $puesto, $password_hash);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/empleados.php?status=success&message=Empleado creado exitosamente.");
    } else {
        if ($conn->errno === 1062) {
            $error_message = "El correo electrónico ya está registrado.";
        } else {
            $error_message = "Error al crear el empleado.";
        }
        header("Location: ../../public/admin/agregar_empleado.php?status=error&message=" . urlencode($error_message));
    }
    $stmt->close();
    $conn->close();
}

?>