<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $membresia_id = $_POST['membresia_id'];

    if (!empty($membresia_id)) {
        $query = "DELETE FROM membresias WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $membresia_id);

        if ($stmt->execute()) {
            echo "Membresía eliminada con éxito.";
        } else {
            echo "Error al eliminar la membresía.";
        }
    } else {
        echo "ID de membresía no válido.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>