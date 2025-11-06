<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador'){
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
    <title>Gestión de Membresías</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Planes de Membresía</h1>
            <div class="header-actions">
                <a href="agregar_membresia.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Crear Nuevo Plan</a>
                <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </header>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-card-list"></i>
                <h3>Planes Disponibles</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Plan</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Duración (Días)</th>
                            <th>Acciones</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM membresias ORDER BY id_membresia ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id_membresia'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                echo "<td>$" . number_format($row['precio'], 2) . "</td>";
                                echo "<td>" . $row['duracion_dias'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_membership.php?id=" . $row['id_membresia'] . "' class='btn btn-secondary' title='Editar'><i class='bi bi-pencil'></i></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>No hay tipos de membresía definidos.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>