<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Membresía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <h2>Nueva Membresía</h2>
    <form action="../../backend/membresias/crear.php" method="POST">
        <div class="mb-3">
            <label for="tipo" class="form-label">Nombre del Plan (Tipo)</label>
            <input type="text" class="form-control" name="tipo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3"></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" name="precio" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="duracion_dias" class="form-label">Duración (en días)</label>
                <input type="number" class="form-control" name="duracion_dias" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="membresias.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>