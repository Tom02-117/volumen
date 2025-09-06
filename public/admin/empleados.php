<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Gestión de Empleados</h1>
            <div>
                <a href="agregar_empleado.php" class="btn btn-primary">Agregar Empleado</a>
                <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Puesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_empleado, nombre, apellido, email, puesto FROM Empleados ORDER BY id_empleado DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_empleado'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['puesto']) . "</td>";
                        echo "<td>";
                        echo "<a href='editar_empleado.php?id=" . $row['id_empleado'] . "' class='btn btn-edit'>Editar</a>";
                        // Evitar que el admin principal se pueda borrar a sí mismo
                        if ($_SESSION['user_id'] != $row['id_empleado']) {
                            echo "<a href='../../backend/empleados/eliminar.php?id=" . $row['id_empleado'] . "' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro?\");'>Eliminar</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay empleados registrados.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>