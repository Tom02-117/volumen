<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador') {
    header("Location: ../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Membresía</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <div class="admin-container" style="max-width: 800px;">
        <header class="admin-header">
            <h1>Crear Plan de Membresía</h1>
            <div class="header-actions">
                <a href="membresias.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </header>

        <div class="card">
            <form action="../../backend/membresias/crear.php" method="POST">
                <div class="form-group">
                    <label class="form-label" for="tipo">Nombre del Plan (Ej: Mensual, Anual)</label>
                    <input type="text" id="tipo" name="tipo" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-input" rows="3"></textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="precio">Precio ($)</label>
                        <input type="number" id="precio" step="0.01" name="precio" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="duracion_dias">Duración (en días)</label>
                        <input type="number" id="duracion_dias" name="duracion_dias" class="form-input" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Guardar Plan</button>
            </form>
        </div>
    </div>
</body>
</html>