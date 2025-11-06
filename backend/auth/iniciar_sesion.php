<?php
session_start();
include '../config/database.php';

$tipo_cedula = $_POST['tipo_documento'] ?? '';
$cedula = $_POST['numero_documento'] ?? '';
$password = $_POST['password'] ?? '';

$redirect_info = $_POST['redirect'] ?? null;
$clase = $_POST['clase'] ?? null;
$dia = $_POST['dia'] ?? null;
$hora = $_POST['hora'] ?? null;

$sql_cliente = "SELECT id_cliente, nombre, password FROM clientes WHERE tipo_cedula = ? AND cedula = ?";
$stmt_cliente = $conn->prepare($sql_cliente);
if ($stmt_cliente) {
    $stmt_cliente->bind_param("ss", $tipo_cedula, $cedula);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();
    if ($result_cliente->num_rows === 1) {
        $cliente = $result_cliente->fetch_assoc();
        if (password_verify($password, $cliente['password'])) {
            $_SESSION['user_id'] = $cliente['id_cliente'];
            $_SESSION['user_nombre'] = $cliente['nombre'];
            $_SESSION['user_tipo'] = 'cliente';

            if ($redirect_info === 'pagar_clase' && !empty($clase)) {
                $queryParams = http_build_query([
                    'item_type' => 'clase',
                    'clase' => $clase,
                    'dia' => $dia,
                    'hora' => $hora
                ]);
                header("Location: ../../public/cliente/pagar_membresia.php?" . $queryParams);
            } else {

                header("Location: ../../public/cliente/panel.php?login=success");
            }

            $stmt_cliente->close();
            $conn->close();
            exit;
        }
    }
    $stmt_cliente->close();
}

$sql_empleado = "SELECT id_empleado, nombre, password, puesto FROM empleados WHERE tipo_cedula = ? AND cedula = ?";
$stmt_empleado = $conn->prepare($sql_empleado);
if ($stmt_empleado) {
    $stmt_empleado->bind_param("ss", $tipo_cedula, $cedula);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();
    if ($result_empleado->num_rows === 1) {
        $empleado = $result_empleado->fetch_assoc();
        if (password_verify($password, $empleado['password'])) {
            $_SESSION['empleado_id'] = $empleado['id_empleado'];
            $_SESSION['user_nombre'] = $empleado['nombre'];
            $_SESSION['user_tipo'] = $empleado['puesto'];
            header("Location: ../../public/admin/index.php?login=success");
            $stmt_empleado->close();
            $conn->close();
            exit;
        }
    }
    $stmt_empleado->close();
}

$conn->close();
header("Location: ../../public/login.html?error=credenciales_invalidas");
exit;
?>