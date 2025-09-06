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
    <title>Crear Tipo de Membresía</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Crear Nuevo Plan de Membresía</h1>
            <a href="membresias.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form action="../../backend/membresias/crear.php" method="POST">
            <div class="form-group">
                <label class="form-label">Nombre del Plan (Ej: Mensual, Anual)</label>
                <input type="text" name="tipo" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-input" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Precio ($)</label>
                <input type="number" step="0.01" name="precio" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Duración (en días)</label>
                <input type="number" name="duracion_dias" class="form-input" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Plan</button>
        </form>
    </div>
</body>
</html>