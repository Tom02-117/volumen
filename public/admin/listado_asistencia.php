<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
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
    <title>Gestión de Asistencia a Clases</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css"> 
    <style>
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Asistencia a Clases</h1>
            <div class="header-actions">
                <a href="../asistencia.html" class="btn btn-primary" target="_blank"><i class="bi bi-plus-circle"></i> Nueva Reserva</a>
                <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </header>

        <?php
        $sql_clases = "SELECT DISTINCT clase FROM asistencia ORDER BY clase ASC";
        $result_clases = $conn->query($sql_clases);
        if ($result_clases->num_rows > 0):
            while ($row_clase = $result_clases->fetch_assoc()):
                $clase = $row_clase['clase'];
                $tabla_id = "tabla_" . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($clase));
        ?>
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-check"></i>
                <h3>Clase: <?php echo htmlspecialchars($clase); ?></h3>
            </div>
            
            <div class="filters">
                <select class="form-input" style="flex: 1;" onchange="filtrarTabla('<?php echo $tabla_id; ?>', 2, this.value)">
                    <option value="">Todos los Días</option>
                    <option>Lunes</option><option>Martes</option><option>Miércoles</option>
                    <option>Jueves</option><option>Viernes</option><option>Sábado</option>
                </select>
                <select class="form-input" style="flex: 1;" onchange="filtrarTabla('<?php echo $tabla_id; ?>', 3, this.value)">
                    <option value="">Todas las Horas</option>
                    <option>6:00 AM</option><option>8:00 AM</option>
                    <option>6:00 PM</option><option>8:00 PM</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="admin-table" id="<?php echo $tabla_id; ?>">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Nombre Completo</th>
                            <th>Día</th>
                            <th>Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_asistencia = "SELECT a.id_asistencia, a.id_cliente, c.nombre, c.apellido, a.dia, a.hora 
                                           FROM asistencia a JOIN clientes c ON a.id_cliente = c.id_cliente
                                           WHERE a.clase = ? 
                                           ORDER BY FIELD(a.dia, 'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'), a.hora";
                        $stmt_asistencia = $conn->prepare($sql_asistencia);
                        $stmt_asistencia->bind_param("s", $clase);
                        $stmt_asistencia->execute();
                        $result_asistencia = $stmt_asistencia->get_result();

                        if ($result_asistencia->num_rows > 0) {
                            while ($row = $result_asistencia->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id_cliente'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['dia']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['hora']) . "</td>";
                                echo "<td><a href='../cliente/cancelar_clase.php?id=" . $row['id_asistencia'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Cancelar esta reserva?\");' title='Cancelar'><i class='bi bi-x-circle'></i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No hay inscritos en esta clase.</td></tr>";
                        }
                        $stmt_asistencia->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
            endwhile;
        else:
            echo "<div class='card'><p>No hay clases con asistencias registradas.</p></div>";
        endif;
        $conn->close();
        ?>
    </div>
    <script>
    function filtrarTabla(tableId, columnIndex, filterValue) {
        let tabla = document.getElementById(tableId);
        let filas = tabla.getElementsByTagName("tr");
        filterValue = filterValue.toLowerCase();

        for (let i = 1; i < filas.length; i++) {
            let celda = filas[i].getElementsByTagName("td")[columnIndex];
            if (celda) {
                let textoCelda = celda.textContent || celda.innerText;
                if (filterValue === "" || textoCelda.toLowerCase().indexOf(filterValue) > -1) {
                    filas[i].style.display = "";
                } else {
                    filas[i].style.display = "none";
                }
            }
        }
    }
    </script>
</body>
</html>