<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';

$planes = $conn->query("SELECT * FROM membresias ORDER BY precio ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Planes - Volumen de Hierro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
        .plan-card h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; }
        .plan-price { font-size: 2.5rem; font-weight: 700; color: var(--dark-color); margin: 1rem 0; }
        .plan-price span { font-size: 1rem; font-weight: 400; color: #6c757d; }
        .plan-features { list-style: none; padding: 0; margin: 1.5rem 0; text-align: left; flex-grow: 1; }
        .plan-features li { margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.5rem; }
        .plan-features li i { color: var(--primary-color); font-weight: bold; }
    </style>
</head>
<body>
    <div class="panel-container">
        <header class="panel-header">
            <div class="header-welcome">
                <div>
                    <h1>Nuestros Planes</h1>
                    <p>Elige el que mejor se adapte a tus metas.</p>
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
                <a href="pagar_membresia.php?plan_id=<?php echo $plan['id_membresia']; ?>" class="btn-primary" style="text-decoration: none; text-align:center;">Seleccionar Plan</a>
            </div>
            <?php endwhile; ?>
        </main>
    </div>
</body>
</html>