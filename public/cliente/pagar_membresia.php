<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';

$plan_id = $_GET['plan_id'] ?? 0;
if (!$plan_id) {
    header("Location: membresias.php"); // Si no hay plan, lo regresamos
    exit;
}

// Obtener detalles del plan seleccionado
$stmt = $conn->prepare("SELECT tipo, precio, descripcion FROM membresias WHERE id_membresia = ?");
$stmt->bind_param("i", $plan_id);
$stmt->execute();
$plan = $stmt->get_result()->fetch_assoc();

if (!$plan) {
    header("Location: membresias.php"); // Si el plan no existe, lo regresamos
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra - Volumen de Hierro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="panel_styles.css">
    <style>
        .confirmation-card {
            max-width: 600px;
            margin: 2rem auto;
            background-color: var(--card-background);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
        }
        .confirmation-card h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .plan-summary {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: left;
        }
        .plan-summary h4 { font-weight: 600; }
        .total-price { font-size: 2rem; font-weight: 700; }
    </style>
</head>
<body>
    <div class="panel-container">
        <div class="confirmation-card">
            <h2><i class="bi bi-credit-card"></i> Confirmar Compra</h2>
            <p>Estás a punto de adquirir el siguiente plan:</p>

            <div class="plan-summary">
                <h4>Plan <?php echo htmlspecialchars($plan['tipo']); ?></h4>
                <p><?php echo htmlspecialchars($plan['descripcion']); ?></p>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>Total a Pagar:</strong>
                    <span class="total-price">$<?php echo number_format($plan['precio'], 0); ?></span>
                </div>
            </div>

            <!-- ESTE ES EL FORMULARIO FINAL QUE PROCESA LA COMPRA -->
            <form action="../../backend/membresias/comprar_membresia.php" method="POST">
                <input type="hidden" name="id_membresia" value="<?php echo $plan_id; ?>">
                <p style="font-size: 0.8rem; color: #666;">
                    Al hacer clic en "Confirmar", se procesará el pago. Esto es una simulación,
                    en un entorno real aquí se integraría una pasarela de pagos como Stripe o MercadoPago.
                </p>
                <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem;">Confirmar y Pagar</button>
            </form>
            <a href="membresias.php" style="display: block; margin-top: 1rem;">Cancelar y volver a los planes</a>
        </div>
    </div>
</body>
</html>