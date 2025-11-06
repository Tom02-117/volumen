<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// INICIAMOS LA SESIÓN AL PRINCIPIO DE TODO
session_start(); 

include '../../backend/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../asistencia.html");
    exit;
}

$cedula = $_POST['cedula'] ?? '';
$password = $_POST['password'] ?? '';
$clase = $_POST['clase'] ?? '';
$dia = $_POST['dia'] ?? '';
$hora = $_POST['hora'] ?? '';

$redirect_params = http_build_query(['clase' => $clase, 'dia' => $dia, 'hora' => $hora]);

if (empty($cedula) || empty($password) || empty($clase)) {
    header("Location: ../asistencia.html?reserva=error&" . $redirect_params);
    exit;
}

// --- 1. VERIFICAR CREDENCIALES DEL USUARIO ---
$stmt_cliente = $conn->prepare("SELECT id_cliente, nombre, password FROM clientes WHERE cedula = ?");
$stmt_cliente->bind_param("s", $cedula);
$stmt_cliente->execute();
$cliente = $stmt_cliente->get_result()->fetch_assoc();
$stmt_cliente->close();

if (!$cliente || !password_verify($password, $cliente['password'])) {
    header("Location: ../asistencia.html?reserva=error&" . $redirect_params);
    exit;
}
$id_cliente = $cliente['id_cliente'];

// ¡CAMBIO IMPORTANTE! SI LAS CREDENCIALES SON CORRECTAS, CREAMOS LA SESIÓN INMEDIATAMENTE
$_SESSION['user_id'] = $cliente['id_cliente'];
$_SESSION['user_nombre'] = $cliente['nombre'];
$_SESSION['user_tipo'] = 'cliente';


// --- 2. VERIFICAR SI TIENE MEMBRESÍA ACTIVA ---
$sql_membresia = "SELECT id_cliente_membresia FROM clientes_membresias WHERE id_cliente = ? AND estado = 'Activa' AND fecha_fin >= CURDATE()";
$stmt_membresia = $conn->prepare($sql_membresia);
$stmt_membresia->bind_param("i", $id_cliente);
$stmt_membresia->execute();
$tiene_membresia_activa = $stmt_membresia->get_result()->num_rows > 0;
$stmt_membresia->close();

if (!$tiene_membresia_activa) {
    header("Location: ../asistencia.html?reserva=sin_membresia&" . $redirect_params);
    exit;
}

// --- 3. VERIFICAR SI YA TIENE UNA CLASE RESERVADA PARA ESE DÍA ---
$sql_check_dia = "SELECT id_asistencia FROM asistencia WHERE id_cliente = ? AND dia = ?";
$stmt_check_dia = $conn->prepare($sql_check_dia);
$stmt_check_dia->bind_param("is", $id_cliente, $dia);
$stmt_check_dia->execute();
$ya_reservo_hoy = $stmt_check_dia->get_result()->num_rows > 0;
$stmt_check_dia->close();

if ($ya_reservo_hoy) {
    header("Location: ../asistencia.html?reserva=limite&" . $redirect_params);
    exit;
}

// --- 4. SI TODAS LAS VERIFICACIONES PASAN, REGISTRAR LA CLASE ---
$sql_insert = "INSERT INTO asistencia (id_cliente, clase, dia, hora, fecha) VALUES (?, ?, ?, ?, NOW())";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("isss", $id_cliente, $clase, $dia, $hora);

if ($stmt_insert->execute()) {
    header("Location: ../asistencia.html?reserva=ok&clase=" . urlencode($clase));
} else {
    header("Location: ../asistencia.html?reserva=error&" . $redirect_params);
}
$stmt_insert->close();
$conn->close();
exit;
?>