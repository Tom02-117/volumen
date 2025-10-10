<?php
session_start();
include '../../backend/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula   = $_POST['cedula'] ?? '';
    $password = $_POST['password'] ?? '';
    $clase    = $_POST['clase'] ?? '';
    $dia      = $_POST['dia'] ?? '';
    $hora     = $_POST['hora'] ?? '';

    if (empty($cedula) || empty($password) || empty($clase) || empty($dia) || empty($hora)) {
        header("Location: asistencia.html?reserva=error");
        exit;
    }


    $sql = "SELECT id_cliente, nombre, apellido, password FROM clientes WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if (!$cliente) {
        header("Location: ../asistencia.html?reserva=error");
        exit;
    }

 
    if (!password_verify($password, $cliente['password'])) {
        header("Location: ../asistencia.html?reserva=error");
        exit;
    }

    $id_cliente       = $cliente['id_cliente'];
    $nombre_clientes  = $cliente['nombre'];
    $apellido_cliente = $cliente['apellido'];

    $check_dia = "SELECT id_asistencia FROM asistencia WHERE id_cliente = ? AND dia = ?";
    $stmt_check_dia = $conn->prepare($check_dia);
    $stmt_check_dia->bind_param("is", $id_cliente, $dia);
    $stmt_check_dia->execute();
    $result_check_dia = $stmt_check_dia->get_result();

    if ($result_check_dia->num_rows > 0) {
        header("Location: ../asistencia.html?reserva=limite&clase=" . urlencode($clase) . "&dia=" . urlencode($dia) . "&hora=" . urlencode($hora));
        exit;
    }



    $insert = "INSERT INTO asistencia 
               (id_cliente, nombre_clientes, apellido_cliente, clase, dia, hora, fecha) 
               VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt_insert = $conn->prepare($insert);
    $stmt_insert->bind_param("isssss", $id_cliente, $nombre_clientes, $apellido_cliente, $clase, $dia, $hora);

    if ($stmt_insert->execute()) {
        header("Location: ../asistencia.html?reserva=ok&clase=" . urlencode($clase) . "&dia=" . urlencode($dia) . "&hora=" . urlencode($hora));
        exit;
    } else {
        header("Location: ../asistencia.html?reserva=error");
        exit;
    }
} else {
    header("Location: ../asistencia.html?reserva=error");
    exit;
}
