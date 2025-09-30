<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <a href="pagar_membresia.php?plan_id=<?php echo $plan_id; ?>" class="btn btn-primary">Confirmar y Pagar</a>
        </div>
    </div>


</body>
</html>
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
$result = $stmt->get_result();
$plan = $result->fetch_assoc();

if (!$plan) {
    header("Location: membresias.php"); 
    exit;
}
?>