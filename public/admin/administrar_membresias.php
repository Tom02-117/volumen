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
    <title>Asignar Membresías</title>
    <link rel="stylesheet" href="../estilos.css">
    <style>
        .search-container { position: relative; }
        #search-results {
            position: absolute; width: 100%; background: white; border: 1px solid #ccc;
            border-top: none; border-radius: 0 0 8px 8px; max-height: 200px;
            overflow-y: auto; z-index: 1000;
        }
        .search-item { padding: 10px 15px; cursor: pointer; }
        .search-item:hover { background-color: #f0f0f0; }
    </style>
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Asignar Membresías</h1>
            <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
        </div>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 40px;">
            <h3>Asignar Nueva Membresía</h3>
            <form action="../../backend/membresias/asignar.php" method="POST">
                <div class="form-group search-container">
                    <label class="form-label">Buscar Cliente Activo</label>
                    <input type="text" id="cliente-search" class="form-input" placeholder="Escribe para buscar..." autocomplete="off">
                    <div id="search-results"></div>
                    <input type="hidden" name="id_cliente" id="id_cliente" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo de Membresía</label>
                    <select name="id_membresia" class="form-input" required>
                         <option value="">Seleccione un plan...</option>
                         <?php
                        $membresiasSql = "SELECT id_membresia, tipo FROM Membresias";
                        $membresiasResult = $conn->query($membresiasSql);
                        while($membresia = $membresiasResult->fetch_assoc()) {
                            echo "<option value='{$membresia['id_membresia']}'>" . htmlspecialchars($membresia['tipo']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-input" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Asignar Membresía</button>
            </form>
        </div>

        <h3>Historial de Membresías Asignadas</h3>
        <table class="table">
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
                FROM Clientes_Membresias cm
                JOIN Clientes c ON cm.id_cliente = c.id_cliente
                LEFT JOIN Membresias m ON cm.id_membresia = m.id_membresia
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
                echo "<tr><td colspan='5' class='text-center'>No hay membresías asignadas.</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
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
                
                const response = await fetch(`../../backend/clientes/buscar.php?query=${encodeURIComponent(query)}`);
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
            });
        });
    </script>
</body>
</html>