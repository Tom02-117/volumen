<?php
session_start();

// Guardia de seguridad: si no hay sesión o no es de tipo 'empleado', expulsar al login.
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page"> <!-- <<< ¡AQUÍ ESTÁ LA CLASE AÑADIDA! -->
    <div class="container">
        <div class="header">
            <h1>Panel de Administración</h1>
            <a href="../../backend/auth/logout.php" class="btn btn-secondary">Cerrar Sesión</a>
        </div>

        <div class="dashboard">
            <a href="clientes.php" class="card">
                <h3>Gestionar Clientes</h3>
                <p>Ver, agregar y editar la información de los clientes.</p>
            </a>
            <a href="empleados.php" class="card">
                <h3>Gestionar Empleados</h3>
                <p>Administrar el personal y sus roles en el sistema.</p>
            </a>
            <a href="membresias.php" class="card">
                <h3>Tipos de Membresía</h3>
                <p>Crear y editar los planes disponibles para los clientes.</p>
            </a>
            <a href="administrar_membresias.php" class="card">
                <h3>Asignar Membresías</h3>
                <p>Asignar planes a los clientes y ver el historial.</p>
            </a>
        </div>
    </div>
</body>
</html>