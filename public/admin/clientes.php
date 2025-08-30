<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container mt-5">
    <a href="index.php" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver al Panel</a>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-person-badge"></i> Gestión de Clientes</h1>
        <a href="agregar_cliente.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar Cliente</a>
    </div>

    <?php
    if (isset($_GET['status'])) {
        $message = htmlspecialchars($_GET['message']);
        $status = $_GET['status'] === 'success' ? 'success' : 'danger';
        echo "<div class='alert alert-{$status} alert-dismissible fade show'>$message<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    }
    ?>
    
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include '../../backend/config/database.php';
        $sql = "SELECT id_cliente, nombre, apellido, email, estado FROM Clientes";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $estado = $row["estado"] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                echo "<tr>";
                echo "<td>" . $row["id_cliente"] . "</td>";
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["apellido"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . $estado . "</td>";
                echo "<td>";
                echo "<a href='editar_cliente.php?id=" . $row["id_cliente"] . "' class='btn btn-primary btn-sm me-2' title='Editar'><i class='bi bi-pencil-square'></i></a>";
                echo "<a href='../../backend/clientes/eliminar.php?id=" . $row["id_cliente"] . "' class='btn btn-danger btn-sm' title='Eliminar' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este cliente?\");'><i class='bi bi-trash-fill'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No hay clientes registrados.</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>