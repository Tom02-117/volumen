<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador'){
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';

$id_empleado = $_GET['id'] ?? 0;
if (!$id_empleado) {
    header("Location: empleados.php"); exit;
}

$sql = "SELECT id_empleado, nombre, apellido, email, puesto, telefono FROM empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$empleado = $stmt->get_result()->fetch_assoc();
if (!$empleado) {
    header("Location: empleados.php"); exit;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css"> 
</head>
<body>
    <div class="admin-container" style="max-width: 800px;">
        <header class="admin-header">
            <h1>Editar Empleado</h1>
            <div class="header-actions">
                <a href="empleados.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </header>

        <div class="card">
             <div class="card-header">
                <i class="bi bi-person-badge-fill"></i>
                <h3>Datos de <?php echo htmlspecialchars($empleado['nombre']); ?></h3>
            </div>
            <form action="../../backend/empleados/actualizar.php" method="POST">
                <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-input" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-input" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($empleado['email']); ?>" required>
                    </div>
                     <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" class="form-input" value="<?php echo htmlspecialchars($empleado['telefono']); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Puesto</label>
                    <select name="puesto" class="form-input" required>
                        <option value="Administrador" <?php if($empleado['puesto'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                        <option value="Recepcionista" <?php if($empleado['puesto'] == 'Recepcionista') echo 'selected'; ?>>Recepcionista</option>
                        <option value="Entrenador" <?php if($empleado['puesto'] == 'Entrenador') echo 'selected'; ?>>Entrenador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" class="form-input" placeholder="Dejar en blanco para no cambiar">
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Actualizar Empleado</button>
            </form>
        </div>
    </div>
</body>
</html>