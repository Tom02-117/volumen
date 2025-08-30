<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <h2>Agregar Nuevo Cliente</h2>
    <hr>
    <form action="../../backend/clientes/crear.php" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" name="apellido" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="telefono">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" class="form-select">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="estado" id="estado" checked>
            <label class="form-check-label" for="estado">
                Cliente Activo
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>