<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';
$id_cliente = $_GET['id'] ?? 0;
if (!$id_cliente) {
    header("Location: clientes.php"); exit;
}
$sql = "SELECT * FROM Clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
if (!$cliente) {
    header("Location: clientes.php"); exit;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="admin-page">
    <div class="container">
        <div class="header">
            <h1>Editar Cliente #<?php echo htmlspecialchars($cliente['id_cliente']); ?></h1>
            <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form action="../../backend/clientes/actualizar.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-input" value="<?php echo htmlspecialchars($cliente['apellido']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-input" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
            </div>
             <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-input">
                    <option value="1" <?php if ($cliente['estado'] == 1) echo 'selected'; ?>>Activo</option>
                    <option value="0" <?php if ($cliente['estado'] == 0) echo 'selected'; ?>>Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-input" placeholder="Dejar en blanco para no cambiar">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        </form>
    </div>
</body>
</html>