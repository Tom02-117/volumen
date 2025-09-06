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
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Agregar Nuevo Cliente</h1>
            <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form action="../../backend/clientes/crear.php" method="POST">
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
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-input" placeholder="El cliente usará esto para iniciar sesión" required>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        </form>
    </div>
</body>
</html>