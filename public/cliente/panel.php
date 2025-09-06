<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';
$id_cliente = $_SESSION['user_id'];

$sql = "
    SELECT m.tipo, m.descripcion, cm.fecha_inicio, cm.fecha_fin, cm.estado
    FROM Clientes_Membresias cm
    JOIN Membresias m ON cm.id_membresia = m.id_membresia
    WHERE cm.id_cliente = ? AND cm.estado = 'Activa'
    ORDER BY cm.fecha_fin DESC
    LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$membresia = $stmt->get_result()->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Volumen de Hierro</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?>!</h2>
            <a href="../../backend/auth/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <h3>Estado de tu Membresía</h3>

        <?php if ($membresia): ?>
            <div class="card">
                <h3>Plan: <?php echo htmlspecialchars($membresia['tipo']); ?></h3>
                <p><?php echo htmlspecialchars($membresia['descripcion']); ?></p>
                <ul>
                    <li><strong>Inicio:</strong> <?php echo date("d/m/Y", strtotime($membresia['fecha_inicio'])); ?></li>
                    <li><strong>Vencimiento:</strong> <?php echo date("d/m/Y", strtotime($membresia['fecha_fin'])); ?></li>
                    <li><strong>Estado:</strong> <?php echo htmlspecialchars($membresia['estado']); ?></li>
                </ul>
            </div>
        <?php else: ?>
            <div class="alert alert-error" style="background-color: #ffc107; color: #333;">
                No tienes ninguna membresía activa. ¡Visita recepción para activar tu plan!
            </div>
        <?php endif; ?>
    </div>
</body>
</html>