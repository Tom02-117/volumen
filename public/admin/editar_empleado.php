<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';

$id_empleado = $_GET['id'] ?? 0;
if (!$id_empleado) {
    header("Location: empleados.php"); exit;
}

$sql = "SELECT nombre, apellido, email, puesto FROM Empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$empleado = $stmt->get_result()->fetch_assoc();
if (!$empleado) {
    header("Location: empleados.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Editar Empleado</h1>
            <a href="empleados.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form action="../../backend/empleados/actualizar.php" method="POST">
            <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-input" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($empleado['email']); ?>" required>
            </div>
             <div class="form-group">
                <label class="form-label">Puesto</label>
                <select name="puesto" class="form-input" required>
                    <option value="Recepcionista" <?php if($empleado['puesto'] == 'Recepcionista') echo 'selected'; ?>>Recepcionista</option>
                    <option value="Entrenador" <?php if($empleado['puesto'] == 'Entrenador') echo 'selected'; ?>>Entrenador</option>
                    <option value="Gerente" <?php if($empleado['puesto'] == 'Gerente') echo 'selected'; ?>>Gerente</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-input" placeholder="Dejar en blanco para no cambiar">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
        </form>
    </div>
</body>
</html>