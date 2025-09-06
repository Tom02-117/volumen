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
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Gestión de Clientes</h1>
            <div>
                <a href="agregar_cliente.php" class="btn btn-primary">Agregar Cliente</a>
                <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_cliente, nombre, apellido, email, estado FROM Clientes ORDER BY id_cliente DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $estado_texto = $row['estado'] ? 'Activo' : 'Inactivo';
                        echo "<tr>";
                        echo "<td>" . $row['id_cliente'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . $estado_texto . "</td>";
                        echo "<td>";
                        echo "<a href='editar_cliente.php?id=" . $row['id_cliente'] . "' class='btn btn-edit'>Editar</a>";
                        echo "<a href='../../backend/clientes/eliminar.php?id=" . $row['id_cliente'] . "' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro?\");'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay clientes registrados.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>