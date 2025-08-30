<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $puesto = $_POST['puesto'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? '';
    $fecha_contratacion = !empty($_POST['fecha_contratacion']) ? $_POST['fecha_contratacion'] : null;
    $salario = !empty($_POST['salario']) ? $_POST['salario'] : null;

    if (empty($nombre) || empty($apellido) || empty($email)) {
        header("Location: ../../public/admin/empleados.php?status=error&message=" . urlencode('Nombre, Apellido y Email son obligatorios.'));
        exit;
    }

    $sql = "INSERT INTO Empleados (nombre, apellido, puesto, telefono, email, fecha_contratacion, salario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $nombre, $apellido, $puesto, $telefono, $email, $fecha_contratacion, $salario);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/empleados.php?status=success&message=" . urlencode('Empleado agregado exitosamente.'));
    } else {
        header("Location: ../../public/admin/empleados.php?status=error&message=" . urlencode('Error al agregar el empleado: ' . $stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>