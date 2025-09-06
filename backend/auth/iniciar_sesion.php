<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql_empleado = "SELECT id_empleado, nombre, puesto, password FROM Empleados WHERE email = ?";
    $stmt_empleado = $conn->prepare($sql_empleado);
    $stmt_empleado->bind_param("s", $email);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();
    
    if ($result_empleado->num_rows === 1) {
        $empleado = $result_empleado->fetch_assoc();
        if (password_verify($password, $empleado['password'])) {
            $_SESSION['user_id'] = $empleado['id_empleado'];
            $_SESSION['user_nombre'] = $empleado['nombre'];
            $_SESSION['user_tipo'] = 'empleado';


            header("Location: ../../public/admin/index.php");
            exit;
        }
    }
    $stmt_empleado->close();

    $sql_cliente = "SELECT id_cliente, nombre, password FROM Clientes WHERE email = ?";
    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $email);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();
    
    if ($result_cliente->num_rows === 1) {
        $cliente = $result_cliente->fetch_assoc();
        if (password_verify($password, $cliente['password'])) {
            $_SESSION['user_id'] = $cliente['id_cliente'];
            $_SESSION['user_nombre'] = $cliente['nombre'];
            $_SESSION['user_tipo'] = 'cliente';
            header("Location: ../../public/cliente/panel.php");
            exit;
        }
    }
    $stmt_cliente->close();

    header("Location: ../../public/login.html?error=1");
    exit;
} else {
    header("Location: ../../public/login.html");
    exit;
}
?>