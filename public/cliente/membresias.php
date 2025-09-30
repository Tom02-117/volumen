<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';
$id_cliente = $_SESSION['user_id'];

// Consultar si el cliente ya tiene una membresía activa para cambiar el texto del botón
$sql_activa = "SELECT id_cliente_membresia FROM clientes_membresias WHERE id_cliente = ? AND estado = 'Activa'";
$stmt_activa = $conn->prepare($sql_activa);
$stmt_activa->bind_param("i", $id_cliente);
$stmt_activa->execute();
$tiene_activa = $stmt_activa->get_result()->num_rows > 0;
$texto_boton = $tiene_activa ? "Mejorar Plan" : "Comprar Plan";

// Consultar todos los planes disponibles
$planes = $conn->query("SELECT * FROM membresias ORDER BY precio ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Planes - Volumen de Hierro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Reutilizamos los estilos del panel de cliente y añadimos algunos específicos -->
    <link rel="stylesheet" href="panel_styles.css">
    <style>
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .plan-card {
            background-color: var(--card-background);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            text-align: center;
            border-top: 5px solid var(--primary-color);
        }
        .plan-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .plan-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 1rem 0;
        }
        .plan-price span {
            font-size: 1rem;
            font-weight: 400;
            color: var(--text-light-color);
        }
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
            text-align: left;
            flex-grow: 1; /* Empuja el botón hacia abajo */
        }
        .plan-features li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .plan-features li i {
            color: var(--primary-color);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="panel-container">
        <header class="panel-header">
            <div class="header-welcome">
                <img src="../../img/logo.png" alt="Logo" class="logo">
                <div>
                    <h1>Nuestros Planes</h1>
                    <p>Elige el plan que mejor se adapte a tus metas.</p>
                </div>
            </div>
            <a href="panel.php" class="btn-logout" style="background-color: #e9ecef; color: var(--dark-color);">
                <i class="bi bi-arrow-left-circle"></i> Volver al Panel
            </a>
        </header>

        <main class="plans-grid">
            <?php while($plan = $planes->fetch_assoc()): ?>
            <div class="plan-card">
                <h3><?php echo htmlspecialchars($plan['tipo']); ?></h3>
                <p class="plan-price">$<?php echo number_format($plan['precio'], 0); ?><span>/mes</span></p>
                <ul class="plan-features">
                    <li><i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($plan['duracion_dias']); ?> días de acceso</li>
                    <li><i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($plan['descripcion']); ?></li>
                </ul>
                <!-- Este enlace lleva a la página de confirmación -->
                <a href="pagar_membresia.php?plan_id=<?php echo $plan['id_membresia']; ?>" class="btn-primary" style="text-decoration: none; text-align:center;"><?php echo $texto_boton; ?></a>
            </div>
            <?php endwhile; ?>
        </main>
    </div>
</body>
</html>