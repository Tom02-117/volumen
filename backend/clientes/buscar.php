<?php
// buscar.php

// Incluir archivo de configuración de base de datos
require_once '../config/database.php';

// Verificar si se ha enviado una solicitud de búsqueda
if (isset($_POST['buscar'])) {
    $nombre_cliente = $_POST['nombre_cliente'];

    // Crear conexión a la base de datos
    $conexion = new mysqli($host, $usuario, $contraseña, $nombre_base_datos);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Preparar la consulta para buscar el cliente
    $stmt = $conexion->prepare("SELECT * FROM clientes WHERE nombre = ?");
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se encontró el cliente
    if ($resultado->num_rows > 0) {
        // Mostrar información del cliente
        while ($fila = $resultado->fetch_assoc()) {
            echo "ID: " . $fila['id'] . "<br>";
            echo "Nombre: " . $fila['nombre'] . "<br>";
            echo "Email: " . $fila['email'] . "<br>";
            // Agregar más campos según sea necesario
        }
    } else {
        echo "No se encontró ningún cliente con ese nombre.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>

<form method="POST" action="">
    <label for="nombre_cliente">Buscar Cliente:</label>
    <input type="text" name="nombre_cliente" id="nombre_cliente" required>
    <input type="submit" name="buscar" value="Buscar">
</form>