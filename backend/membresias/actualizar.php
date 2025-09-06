<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];

    if (empty($id) || empty($nombre) || empty($precio) || empty($duracion)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $query = "UPDATE membresias SET nombre = ?, precio = ?, duracion = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nombre, $precio, $duracion, $id);

    if ($stmt->execute()) {
        echo "Membresía actualizada con éxito.";
    } else {
        echo "Error al actualizar la membresía: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>