<?php
if (!isset($_GET['id'])) {
    header("Location: clientes.php?status=error&message=ID no especificado.");
    exit;
}
$id_cliente = $_GET['id'];

include '../../backend/config/database.php';

$sql = "SELECT * FROM Clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: clientes.php?status=error&message=Cliente no encontrado.");
    exit;
}
$cliente = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <h2>Editar Cliente #<?php echo htmlspecialchars($cliente['id_cliente']); ?></h2>
    <hr>
    <form action="../../backend/clientes/actualizar.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($cliente['apellido']); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo htmlspecialchars($cliente['fecha_nacimiento']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select">
                    <option value="M" <?php echo ($cliente['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                    <option value="F" <?php echo ($cliente['sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                    <option value="Otro" <?php echo ($cliente['sexo'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                </select>
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="estado" id="estado" <?php echo ($cliente['estado']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="estado">Cliente Activo</label>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>