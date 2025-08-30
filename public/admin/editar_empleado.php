<?php
// Obtener el ID del empleado de la URL
if (!isset($_GET['id'])) {
    header("Location: empleados.php?status=error&message=ID de empleado no especificado.");
    exit;
}
$id_empleado = $_GET['id'];

include '../../backend/config/database.php';

// Obtener los datos actuales del empleado
$sql = "SELECT * FROM Empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: empleados.php?status=error&message=Empleado no encontrado.");
    exit;
}
$empleado = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <h2>Editar Empleado #<?php echo htmlspecialchars($empleado['id_empleado']); ?></h2>
    <hr>
    <form action="../../backend/empleados/actualizar.php" method="POST">
        <!-- Campo oculto para enviar el ID -->
        <input type="hidden" name="id_empleado" value="<?php echo $empleado['id_empleado']; ?>">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($empleado['email']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empleado['telefono']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo htmlspecialchars($empleado['puesto']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="number" step="0.01" class="form-control" id="salario" name="salario" value="<?php echo htmlspecialchars($empleado['salario']); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
            <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" value="<?php echo htmlspecialchars($empleado['fecha_contratacion']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
        <a href="empleados.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>