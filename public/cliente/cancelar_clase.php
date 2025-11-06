<?php
session_start();
include '../../backend/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_asistencia = $_POST['id_asistencia'] ?? 0;

    if ($id_asistencia > 0) {
        $sql = "DELETE FROM asistencia WHERE id_asistencia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_asistencia);

        if ($stmt->execute()) {
            header("Location: panel.php?cancel=ok");
            exit;
        } else {
            header("Location: panel.php?cancel=error");
            exit;
        }
    }
}
header("Location: panel.php?cancel=error");
exit;
