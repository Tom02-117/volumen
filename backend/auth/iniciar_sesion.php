<?php
session_start();
include '../config/database.php';

// --- 1. Recibir TODOS los datos del formulario ---
$tipo_cedula = $_POST['tipo_documento'] ?? '';
$cedula = $_POST['numero_documento'] ?? '';
$password = $_POST['password'] ?? '';

// Datos de redirección (los más importantes)
$redirect_info = $_POST['redirect'] ?? null;
$clase = $_POST['clase'] ?? null;
$dia = $_POST['dia'] ?? null;
$hora = $_POST['hora'] ?? null;

// --- 2. Intentar iniciar sesión como Cliente ---
$sql_cliente = "SELECT id_cliente, nombre, password FROM clientes WHERE tipo_cedula = ? AND cedula = ?";
$stmt_cliente = $conn->prepare($sql_cliente);
if ($stmt_cliente) {
    $stmt_cliente->bind_param("ss", $tipo_cedula, $cedula);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();
    if ($result_cliente->num_rows === 1) {
        $cliente = $result_cliente->fetch_assoc();
        if (password_verify($password, $cliente['password'])) {
            // ¡LOGIN DE CLIENTE EXITOSO!
            $_SESSION['user_id'] = $cliente['id_cliente'];
            $_SESSION['user_nombre'] = $cliente['nombre'];
            $_SESSION['user_tipo'] = 'cliente';

            // --- LÓGICA DE REDIRECCIÓN INTELIGENTE (CORREGIDA Y BLINDADA) ---
            if ($redirect_info === 'pagar_clase' && !empty($clase)) {
                // Si el formulario envió la orden de "pagar_clase"...
                // Construimos la URL para la página de pago.
                $queryParams = http_build_query([
                    'item_type' => 'clase',
                    'clase' => $clase,
                    'dia' => $dia,
                    'hora' => $hora
                ]);
                // Redirigimos a la página de pago multi-propósito.
                header("Location: ../../public/cliente/pagar_membresia.php?" . $queryParams);
            } else {
                // Si NO hay orden de pago, se va al panel normal.
                header("Location: ../../public/cliente/panel.php?login=success");
            }
            // ¡Importante! Salimos del script después de redirigir para evitar problemas.
            $stmt_cliente->close();
            $conn->close();
            exit;
        }
    }
    $stmt_cliente->close();
}

// --- 3. Si no es cliente, intentar como Empleado (Admin) ---
$sql_empleado = "SELECT id_empleado, nombre, password, puesto FROM empleados WHERE tipo_cedula = ? AND cedula = ?";
$stmt_empleado = $conn->prepare($sql_empleado);
if ($stmt_empleado) {
    $stmt_empleado->bind_param("ss", $tipo_cedula, $cedula);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();
    if ($result_empleado->num_rows === 1) {
        $empleado = $result_empleado->fetch_assoc();
        if (password_verify($password, $empleado['password'])) {
            // ¡LOGIN DE EMPLEADO EXITOSO!
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

// --- 4. Si ninguna autenticación funcionó, devolver error ---
$conn->close();
header("Location: ../../public/login.html?error=credenciales_invalidas");
exit;
?>