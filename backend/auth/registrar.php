<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_cedula = $_POST['tipo_cedula'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

   
    if (empty($tipo_cedula) || empty($cedula) || empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($telefono)) {
        header("Location: ../../public/crearcuenta.html?error=campos_vacios");
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: ../../public/crearcuenta.html?error=password_no_coincide");
        exit;
    }

    if (strlen($password) < 8) {
        header("Location: ../../public/crearcuenta.html?error=password_corta");
        exit;
    }

    // Validar que no exista ya el email
    $sql_check = "SELECT id_cliente FROM clientes WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        header("Location: ../../public/crearcuenta.html?error=email_existente");
        exit;
    }
    $stmt_check->close();

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo cliente
    $sql_insert = "INSERT INTO clientes (tipo_cedula, cedula, nombre, apellido, telefono, email, fecha_nacimiento, sexo, password, fecha_registro, estado) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)";

    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssss", $tipo_cedula, $cedula, $nombre, $apellido, $telefono, $email, $fecha_nacimiento, $sexo, $password_hash);

    if ($stmt_insert->execute()) {
        header("Location: ../../public/login.html?status=registro_exitoso");
        exit;
    } else {
        die("Error al insertar: " . $stmt_insert->error);
    }

    $stmt_insert->close();
    $conn->close();
}
?>
