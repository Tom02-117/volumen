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
    <title>Asignar Membresías</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Asignar Membresías</h1>
            <div class="header-actions">
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
                <i class="bi bi-person-plus"></i>
                <h3>Asignar Nueva Membresía</h3>
            </div>
            <form action="../../backend/membresias/asignar.php" method="POST">
                <div class="form-grid">
                    <div class="form-group search-container">
                        <label class="form-label" for="cliente-search">Buscar Cliente Activo (por nombre o cédula)</label>
                        <input type="text" id="cliente-search" class="form-input" placeholder="Escribe para buscar..." autocomplete="off">
                        <div id="search-results"></div>
                        <input type="hidden" name="id_cliente" id="id_cliente" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="id_membresia">Tipo de Membresía</label>
                        <select name="id_membresia" id="id_membresia" class="form-input" required>
                            <option value="">Seleccione un plan...</option>
                            <?php
                            $membresiasSql = "SELECT id_membresia, tipo FROM membresias ORDER BY tipo ASC";
                            $membresiasResult = $conn->query($membresiasSql);
                            while($membresia = $membresiasResult->fetch_assoc()) {
                                echo "<option value='{$membresia['id_membresia']}'>" . htmlspecialchars($membresia['tipo']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fecha_inicio">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-input" value="<?php echo date('Y-m-d'); ?>" required style="max-width: 250px;">
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle"></i> Asignar Membresía</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history"></i>
                <h3>Historial Reciente de Membresías</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Membresía</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $historialSql = "
                        SELECT c.nombre, c.apellido, m.tipo, cm.fecha_inicio, cm.fecha_fin, cm.estado
                        FROM clientes_membresias cm
                        JOIN clientes c ON cm.id_cliente = c.id_cliente
                        LEFT JOIN membresias m ON cm.id_membresia = m.id_membresia
                        ORDER BY cm.fecha_inicio DESC LIMIT 20";
                    
                    $historialResult = $conn->query($historialSql);
                    if ($historialResult->num_rows > 0) {
                        while($row = $historialResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tipo'] ?? 'Plan Eliminado') . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($row['fecha_inicio'])) . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($row['fecha_fin'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>No hay membresías asignadas.</td></tr>";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('cliente-search');
            const resultsContainer = document.getElementById('search-results');
            const hiddenClientId = document.getElementById('id_cliente');

            searchInput.addEventListener('keyup', async function() {
                const query = searchInput.value;
                resultsContainer.innerHTML = '';
                hiddenClientId.value = '';

                if (query.length < 2) { return; }
                
                try {
                    const response = await fetch(`../../backend/clientes/buscar.php?query=${encodeURIComponent(query)}`);
                    if (!response.ok) return;
                    
                    const clientes = await response.json();
                    
                    clientes.forEach(cliente => {
                        const item = document.createElement('div');
                        item.className = 'search-item';
                        item.textContent = `${cliente.nombre} ${cliente.apellido}`;
                        item.dataset.id = cliente.id_cliente;
                        resultsContainer.appendChild(item);

                        item.addEventListener('click', function() {
                            searchInput.value = this.textContent;
                            hiddenClientId.value = this.dataset.id;
                            resultsContainer.innerHTML = '';
                        });
                    });
                } catch(error) {
                    console.error("Error al buscar clientes:", error);
                }
            });
            


            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target)) {
                    resultsContainer.innerHTML = '';
                }
            });
        });
    </script>
</body>
</html>