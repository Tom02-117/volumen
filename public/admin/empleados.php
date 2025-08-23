<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-people-fill"></i> Gestión de Empleados</h1>
        <a href="agregar_empleado.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar Empleado</a>
    </div>

    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $message = htmlspecialchars($_GET['message']);
        if ($status === 'success') {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$message<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        } elseif ($status === 'error') {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        }
    }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include '../../backend/config/database.php';

            $sql = "SELECT id_empleado, nombre, apellido, puesto, email FROM Empleados ORDER BY id_empleado DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_empleado"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["apellido"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["puesto"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editar_empleado.php?id=" . $row["id_empleado"] . "' class='btn btn-primary btn-sm me-2' title='Editar'><i class='bi bi-pencil-square'></i></a>";
                    echo "<a href='../../backend/empleados/eliminar.php?id=" . $row["id_empleado"] . "' class='btn btn-danger btn-sm' title='Eliminar' onclick='return confirm(\"¿Estás seguro de que quieres eliminar a este empleado?\");'><i class='bi bi-trash-fill'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay empleados registrados.</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>