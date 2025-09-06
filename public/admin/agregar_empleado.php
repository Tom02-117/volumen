<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Agregar Nuevo Empleado</h1>
            <a href="empleados.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form action="../../backend/empleados/crear.php" method="POST">
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" required>
            </div>
             <div class="form-group">
                <label class="form-label">Puesto</label>
                <select name="puesto" class="form-input" required>
                    <option value="Recepcionista">Recepcionista</option>
                    <option value="Entrenador">Entrenador</option>
                    <option value="Gerente">Gerente</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Empleado</button>
        </form>
    </div>
</body>
</html>