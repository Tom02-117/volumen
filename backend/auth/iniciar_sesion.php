<?php
session_start();
include '../config/database.php';

$tipo_cedula = $_POST['tipo_documento'] ?? '';
$cedula = $_POST['numero_documento'] ?? '';
$password = $_POST['password'] ?? '';

$sql_cliente = "SELECT id_cliente, nombre, password FROM clientes WHERE tipo_cedula = ? AND cedula = ?";
$stmt_cliente = $conn->prepare($sql_cliente);
$stmt_cliente->bind_param("ss", $tipo_cedula, $cedula);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();

if ($result_cliente->num_rows === 1) {
    $cliente = $result_cliente->fetch_assoc();
    var_dump($cliente['password']);
    if (password_verify($password, $cliente['password'])) {
        $_SESSION['user_id'] = $cliente['id_cliente'];
        $_SESSION['user_nombre'] = $cliente['nombre'];
        $_SESSION['user_tipo'] = 'cliente';
        header("Location: ../../public/cliente/panel.php?login=success&tipo=Cliente");

        exit;
    }
}
$sql_empleados = "SELECT id_empleado, nombre, password, puesto FROM empleados WHERE tipo_cedula = ? AND cedula = ?";
$stmt_empleados = $conn->prepare($sql_empleados);
$stmt_empleados->bind_param("ss", $tipo_cedula, $cedula);
$stmt_empleados->execute();
$result_empleados = $stmt_empleados->get_result();

if ($result_empleados->num_rows === 1) {
    $empleados = $result_empleados->fetch_assoc();
    if (password_verify($password, $empleados['password'])) {
        $_SESSION['empleado_id'] = $empleados['id_empleado'];
        $_SESSION['user_nombre'] = $empleados['nombre'];
        $_SESSION['user_tipo'] = $empleados['puesto']; 
         header("Location: ../../public/admin/index.php?login=success&tipo=Administrador");
         exit;
    }
}
if (isset($stmt_cliente)) {
    $stmt_cliente->close();
}
if (isset($stmt_empleados)) {
    $stmt_empleados->close();
}

$conn->close();


header("Location: ../../public/login.html?error=credenciales_invalidas");
exit;
