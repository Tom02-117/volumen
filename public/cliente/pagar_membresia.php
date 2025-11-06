<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';

$item_type = $_GET['item_type'] ?? null;

$titulo_compra = '';
$descripcion_compra = '';
$precio_compra = 0.00;
$id_membresia_compra = 0;
$clase_info = [];

if ($item_type === 'clase') {
    $clase_info = [
        'clase' => $_GET['clase'] ?? 'N/A',
        'dia'   => $_GET['dia'] ?? 'N/A',
        'hora'  => $_GET['hora'] ?? 'N/A'
    ];
    $titulo_compra = "Clase: " . htmlspecialchars($clase_info['clase']);
    $descripcion_compra = "Reserva para el día " . htmlspecialchars($clase_info['dia']) . " a las " . htmlspecialchars($clase_info['hora']);
    $precio_compra = 5.00;

} else {
    $item_type = 'membresia'; 
    $id_membresia_compra = $_GET['plan_id'] ?? 0;
    if (!$id_membresia_compra) { header("Location: membresias.php?error=plan_invalido"); exit; }
    
    $stmt = $conn->prepare("SELECT tipo, precio, descripcion FROM membresias WHERE id_membresia = ?");
    $stmt->bind_param("i", $id_membresia_compra);
    $stmt->execute();
    $plan = $stmt->get_result()->fetch_assoc();
    if (!$plan) { header("Location: membresias.php?error=plan_no_encontrado"); exit; }
    
    $titulo_compra = "Plan: " . htmlspecialchars($plan['tipo']);
    $descripcion_compra = htmlspecialchars($plan['descripcion']);
    $precio_compra = $plan['precio'];
}

$payPalClientId = "AbwVdvNuQxFW2CYwIv-NHpMRWapxOCutxQTXR5-3oJ2qDOUArY-UG0vQ2ZXVsl6-XymvzWYDxHIVofgk";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pago</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="panel_styles.css">
    <style>
        .confirmation-card { max-width: 600px; margin: 2rem auto; text-align: center; }
        .plan-summary { background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; text-align: left; }
        .total-price { font-size: 2rem; font-weight: 700; }
        #paypal-button-container { margin-top: 1.5rem; }
    </style>
</head>
<body>
    <div class="panel-container">
        <div class="card confirmation-card">
            <h2><i class="bi bi-wallet2"></i> Finalizar Pago</h2>
            <div class="plan-summary">
                <h4><?php echo $titulo_compra; ?></h4>
                <p><?php echo $descripcion_compra; ?></p>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>Total a Pagar (USD):</strong>
                    <span class="total-price">$<?php echo number_format($precio_compra, 2); ?></span>
                </div>
            </div>

            <div id="paypal-button-container"></div>
            <a href="<?php echo $item_type === 'clase' ? '../asistencia.html' : 'membresias.php'; ?>" style="display: block; margin-top: 1rem;">Cancelar</a>
        </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $payPalClientId; ?>&currency=USD"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        description: "<?php echo addslashes($titulo_compra); ?>",
                        amount: { value: '<?php echo $precio_compra; ?>' }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    let postData = {
                        orderID: data.orderID,
                        item_type: '<?php echo $item_type; ?>'
                    };
                    <?php if ($item_type === 'clase'): ?>
                        postData.clase = "<?php echo addslashes($clase_info['clase']); ?>";
                        postData.dia = "<?php echo addslashes($clase_info['dia']); ?>";
                        postData.hora = "<?php echo addslashes($clase_info['hora']); ?>";
                    <?php else: ?>
                        postData.id_membresia = <?php echo $id_membresia_compra; ?>;
                    <?php endif; ?>

                    fetch('/volumen-main/backend/membresias/comprar_item.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(postData)
                    })
                    .then(response => response.json())
                    .then(serverData => {
                        if (serverData.status === 'success') {
                            window.location.href = 'panel.php?compra=exito';
                        } else {
                            alert('Hubo un error al procesar tu compra: ' + serverData.message);
                        }
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>