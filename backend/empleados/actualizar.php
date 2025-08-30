<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_empleado = $_POST['id_empleado'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $puesto = $_POST['puesto'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? '';
    $fecha_contratacion = !empty($_POST['fecha_contratacion']) ? $_POST['fecha_contratacion'] : null;
    $salario = !empty($_POST['salario']) ? $_POST['salario'] : null;

    if (empty($id_empleado) || empty($nombre) || empty($apellido) || empty($email)) {
        header("Location: ../../public/admin/empleados.php?status=error&message=" . urlencode('Faltan datos obligatorios.'));
        exit;
    }

    $sql = "UPDATE Empleados SET nombre = ?, apellido = ?, puesto = ?, telefono = ?, email = ?, fecha_contratacion = ?, salario = ? WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdi", $nombre, $apellido, $puesto, $telefono, $email, $fecha_contratacion, $salario, $id_empleado);

    if ($stmt->execute()) {
        header("Location: ../../public/admin/empleados.php?status=success&message=" . urlencode('Empleado actualizado exitosamente.'));
    } else {
        header("Location: ../../public/admin/empleados.php?status=error&message=" . urlencode('Error al actualizar: ' . $stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>