<?php
// Obtener el ID del cliente de la URL
if (!isset($_GET['id'])) {
    header("Location: clientes.php?status=error&message=ID de cliente no especificado.");
    exit;
}
$id_cliente = $_GET['id'];

include '../../backend/config/database.php';

// Obtener los datos actuales del empleado
$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: clientes.php?status=error&message=cliente no encontrado.");
    exit;
}
$cliente = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <h2>Editar cliente #<?php echo htmlspecialchars($cliente['id_cliente']); ?></h2>
    <hr>
    <form action="../../backend/clientes/actualizar.php" method="POST">
        <!-- Campo oculto para enviar el ID -->
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($cliente['apellido']); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo htmlspecialchars($cliente['puesto']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="number" step="0.01" class="form-control" id="salario" name="salario" value="<?php echo htmlspecialchars($cliente['salario']); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
            <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" value="<?php echo htmlspecialchars($cliente['fecha_contratacion']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar cliente</button>
        <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>