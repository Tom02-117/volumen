<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') { die("Acceso denegado."); }
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_empleado = $_POST['id_empleado'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $puesto = $_POST['puesto'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($id_empleado) || empty($nombre) || empty($email) || empty($puesto)) {
        header("Location: ../../public/admin/empleados.php?status=error&message=Faltan datos."); exit;
    }

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE Empleados SET nombre = ?, apellido = ?, email = ?, puesto = ?, password = ? WHERE id_empleado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $puesto, $password_hash, $id_empleado);
    } else {
        $sql = "UPDATE Empleados SET nombre = ?, apellido = ?, email = ?, puesto = ? WHERE id_empleado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $puesto, $id_empleado);
    }

    if ($stmt->execute()) {
        header("Location: ../../public/admin/empleados.php?status=success&message=Empleado actualizado.");
    } else {
        header("Location: ../../public/admin/empleados.php?status=error&message=Error al actualizar.");
    }
    $stmt->close();
    $conn->close();
}
?>