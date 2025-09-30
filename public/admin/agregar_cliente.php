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
    <title>Agregar Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css"> 
</head>
<body>
    <div class="admin-container" style="max-width: 800px;">
        <header class="admin-header">
            <h1>Agregar Nuevo Cliente</h1>
            <div class="header-actions">
                <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </header>

        <div class="card">
            <form action="../../backend/clientes/crear.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellido(s)</label>
                        <input type="text" name="apellido" class="form-input" required>
                    </div>
                </div>
                <div class="form-grid">
                     <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" class="form-input">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="tipo_cedula" class="form-input" required>
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="PA">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número de Documento</label>
                        <input type="text" name="cedula" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" placeholder="El cliente usará esto para iniciar sesión" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Guardar Cliente</button>
            </form>
        </div>
    </div>
</body>
</html>