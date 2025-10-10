<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';

$plan_id = $_GET['plan_id'] ?? 0;
if (!$plan_id) {
    header("Location: membresias.php");
    exit;
}

$stmt = $conn->prepare("SELECT tipo, precio, descripcion FROM membresias WHERE id_membresia = ?");
$stmt->bind_param("i", $plan_id);
$stmt->execute();
$plan = $stmt->get_result()->fetch_assoc();

if (!$plan) {
    header("Location: membresias.php");
    exit;
}

// --- CONFIGURACIÓN DE PAYPAL ---
// ¡ACCIÓN REQUERIDA! Pega tu Client ID de Sandbox aquí.
$payPalClientId = "AbwVdvNuQxFW2CYwIv-NHpMRWapxOCutxQTXR5-3oJ2qDOUArY-UG0vQ2ZXVsl6-XymvzWYDxHIVofgk";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pago - Volumen de Hierro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="panel_styles.css">
    <style>
        .confirmation-card { max-width: 600px; margin: 2rem auto; text-align: center; }
        .plan-summary { background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; text-align: left; }
        .total-price { font-size: 2rem; font-weight: 700; }
        #paypal-button-container { margin-top: 1.5rem; }
        .error-message { color: #842029; background-color: #f8d7da; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500; }
    </style>
</head>
<body>
    <div class="panel-container">
        <div class="card confirmation-card">
            <h2><i class="bi bi-wallet2"></i> Finalizar Pago</h2>
            <div class="plan-summary">
                <h4><?php echo htmlspecialchars($plan['tipo']); ?></h4>
                <p><?php echo htmlspecialchars($plan['descripcion']); ?></p>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>Total a Pagar (USD):</strong>
                    <span class="total-price">$<?php echo number_format($plan['precio'], 2); ?></span>
                </div>
            </div>

            <div id="paypal-button-container"></div>
            
            <a href="membresias.php" style="display: block; margin-top: 1rem;">Cancelar y volver</a>
        </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $payPalClientId; ?>&currency=USD"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        description: "<?php echo htmlspecialchars(addslashes($plan['tipo'])); ?>",
                        amount: { value: '<?php echo $plan['precio']; ?>' }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    const fetchUrl = '/volumen-main/backend/membresias/comprar_membresia.php';
                    
                    fetch(fetchUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            id_membresia: <?php echo $plan_id; ?>,
                            orderID: data.orderID
                        })
                    })
                    .then(response => response.json())
                    .then(serverData => {
                        if (serverData.status === 'success') {
                            window.location.href = '../cliente/panel.php?compra=exito';
                        } else {
                            alert('Hubo un error al procesar tu membresía: ' + serverData.message);
                            window.location.href = '../cliente/membresias.php?compra=error';
                        }
                    })
                    .catch(error => {
                        console.error('Error en fetch:', error);
                        alert('Error de comunicación con el servidor. Por favor, contacta a soporte.');
                    });
                });
            },
            onError: function(err) {
                console.error('Error en SDK de PayPal:', err);
                alert('No se pudo iniciar el proceso de pago. Inténtalo de nuevo.');
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>