<?php
session_start();
if (!isset($_SESSION['empleado_id']) || $_SESSION['user_tipo'] !== 'Administrador'){
    header("Location: ../login.html");
    exit;
}
include '../../backend/config/database.php';
$id_cliente = $_GET['id'] ?? 0;
if (!$id_cliente) {
    header("Location: clientes.php"); exit;
}
$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin1.css"> 
</head>
<body>
    <div class="admin-container" style="max-width: 800px;">
        <header class="admin-header">
            <h1>Editar Cliente</h1>
            <div class="header-actions">
                <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </header>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-fill"></i>
                <h3>Datos de <?php echo htmlspecialchars($cliente['nombre']); ?></h3>
            </div>
            <form action="../../backend/clientes/actualizar.php" method="POST">
                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-input" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellido(s)</label>
                        <input type="text" name="apellido" class="form-input" value="<?php echo htmlspecialchars($cliente['apellido']); ?>" required>
                    </div>
                </div>
                <div class="form-grid">
                     <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" class="form-input" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="tipo_cedula" class="form-input" required>
                            <option value="CC" <?php if ($cliente['tipo_cedula'] == "CC") echo "selected"; ?>>Cédula de Ciudadanía</option>
                            <option value="PA" <?php if ($cliente['tipo_cedula'] == "PA") echo "selected"; ?>>Pasaporte</option>
                            <option value="CE" <?php if ($cliente['tipo_cedula'] == "CE") echo "selected"; ?>>Cédula de Extranjería</option>
                            <option value="TI" <?php if ($cliente['tipo_cedula'] == "TI") echo "selected"; ?>>Tarjeta de Identidad</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número de Documento</label>
                        <input type="text" name="cedula" class="form-input" value="<?php echo htmlspecialchars($cliente['cedula']); ?>" required>
                    </div>
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
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Actualizar Cliente</button>
            </form>
        </div>
    </div>
</body>
</html>