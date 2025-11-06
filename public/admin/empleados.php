<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador') {
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css"> 
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Gestión de Empleados</h1>
            <div class="header-actions">
                <a href="agregar_empleado.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Agregar Empleado</a>
                <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </header>

        <div class="card">
             <div class="card-header">
                <i class="bi bi-person-badge"></i>
                <h3>Listado de Empleados</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
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
                        $sql = "SELECT id_empleado, nombre, apellido, email, puesto FROM Empleados ORDER BY id_empleado ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id_empleado'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['puesto']) . "</td>";
                                echo "<td>";
                                echo "<a href='editar_empleado.php?id=" . $row['id_empleado'] . "' class='btn btn-secondary btn-sm' title='Editar'><i class='bi bi-pencil'></i></a> ";
                                if ($_SESSION['empleado_id'] != $row['id_empleado']) { 
                                    echo "<a href='../../backend/empleados/eliminar.php?id=" . $row['id_empleado'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro?\");' title='Eliminar'><i class='bi bi-trash'></i></a>";
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
        </div>
    </div>
    <style> 
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; }
    </style>
</body>
</html>