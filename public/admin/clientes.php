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
    <title>Gestión de Clientes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Gestión de Clientes</h1>
            <div class="header-actions">
                <a href="agregar_cliente.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Agregar Cliente</a>
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
                <i class="bi bi-people-fill"></i>
                <h3>Listado de Clientes</h3>
            </div>
            
            <form method="GET" class="form-group" role="search">
                <div class="input-group" style="display: flex; gap: 0.5rem;">
                    <input class="form-input" style="flex-grow: 1;" type="search" name="busqueda" placeholder="Buscar por nombre o cédula..." value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                    <a href="clientes.php" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Email / Teléfono</th>
                            <th>Documento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_cliente, nombre, apellido, email, telefono, tipo_cedula, cedula, estado FROM Clientes";
                        if (!empty($_GET['busqueda'])) {
                            $busqueda = strtolower($conn->real_escape_string($_GET['busqueda']));
                            $sql .= " WHERE LOWER(CONCAT(TRIM(nombre), ' ', TRIM(apellido))) LIKE '%$busqueda%' 
                                    OR cedula LIKE '%$busqueda%'";
                        }
                        $sql .= " ORDER BY id_cliente DESC";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $estado_clase = $row['estado'] ? 'status-active' : 'status-inactive';
                                $estado_texto = $row['estado'] ? 'Activo' : 'Inactivo';
                                echo "<tr>";
                                echo "<td>" . $row['id_cliente'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                                echo "<td><div>" . htmlspecialchars($row['email']) . "</div><small style='color:#6c757d;'>" . htmlspecialchars($row['telefono']) . "</small></td>";
                                echo "<td>" . htmlspecialchars($row['tipo_cedula']) . " " . htmlspecialchars($row['cedula']) . "</td>";
                                echo "<td><span class='status-badge " . $estado_clase . "'>" . $estado_texto . "</span></td>";
                                echo "<td>";
                                echo "<a href='editar_cliente.php?id=" . $row['id_cliente'] . "' class='btn btn-secondary btn-sm' title='Editar'><i class='bi bi-pencil'></i></a> ";
                                echo "<a href='../../backend/clientes/eliminar.php?id=" . $row['id_cliente'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro?\");' title='Eliminar'><i class='bi bi-trash'></i></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No se encontraron clientes.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style> 
        .status-badge { padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 600; font-size: 0.8rem; }
        .status-active { background-color: #d1e7dd; color: #0f5132; }
        .status-inactive { background-color: #f8d7da; color: #842029; }
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; }
    </style>
</body>
</html>