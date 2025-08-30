<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tipos de Membresía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container mt-5">
    <a href="index.php" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver al Panel</a>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-tags-fill"></i> Tipos de Membresía</h1>
        <a href="agregar_membresia.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nueva Membresía</a>
    </div>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Duración (Días)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include '../../backend/config/database.php';
        $sql = "SELECT * FROM Membresias";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_membresia"] . "</td>";
                echo "<td>" . htmlspecialchars($row["tipo"]) . "</td>";
                echo "<td>$" . number_format($row["precio"], 2) . "</td>";
                echo "<td>" . $row["duracion_dias"] . "</td>";
                echo "<td><a href='#' class='btn btn-primary btn-sm'><i class='bi bi-pencil-square'></i></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No hay tipos de membresía definidos.</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>