<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- Validaciones de Seguridad ---
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
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

    $sql_check = "SELECT id_cliente FROM Clientes WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        header("Location: ../../public/crearcuenta.html?error=email_existente");
        exit;
    }
    $stmt_check->close();
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO Clientes (nombre, apellido, email, password, fecha_registro, estado) VALUES (?, ?, ?, ?, CURDATE(), 1)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $nombre, $apellido, $email, $password_hash);

    if ($stmt_insert->execute()) {
        header("Location: ../../public/login.html?status=registro_exitoso");
        exit;
    } else {
        header("Location: ../../public/crearcuenta.html?error=db_error");
        exit;
    }
    $stmt_insert->close();
    $conn->close();
}
?>