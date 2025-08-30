<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $id_membresia = $_POST['id_membresia'] ?? 0;
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';

    if (empty($id_cliente) || empty($id_membresia) || empty($fecha_inicio)) {
        header("Location: ../../public/admin/administrar_membresias.php?status=error&message=" . urlencode('Todos los campos son obligatorios.'));
        exit;
    }

    $sql_duracion = "SELECT duracion_dias FROM Membresias WHERE id_membresia = ?";
    $stmt_duracion = $conn->prepare($sql_duracion);
    $stmt_duracion->bind_param("i", $id_membresia);
    $stmt_duracion->execute();
    $resultado = $stmt_duracion->get_result();
    $membresia = $resultado->fetch_assoc();
    $duracion_dias = $membresia['duracion_dias'];
    $stmt_duracion->close();

    $fecha_fin_obj = new DateTime($fecha_inicio);
    $fecha_fin_obj->modify("+" . $duracion_dias . " days");
    $fecha_fin = $fecha_fin_obj->format('Y-m-d');

    $sql_insert = "INSERT INTO Clientes_Membresias (id_cliente, id_membresia, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiss", $id_cliente, $id_membresia, $fecha_inicio, $fecha_fin);
    
    if ($stmt_insert->execute()) {
        header("Location: ../../public/admin/administrar_membresias.php?status=success&message=" . urlencode('Membresía asignada correctamente.'));
    } else {
        header("Location: ../../public/admin/administrar_membresias.php?status=error&message=" . urlencode('Error al asignar la membresía: ' . $stmt_insert->error));
    }

    $stmt_insert->close();
    $conn->close();
}
?>
