<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: ../login.html");
    exit;
}

include '../../backend/config/database.php';
$id_cliente = $_SESSION['user_id'];

$sql_membresia = "
    SELECT m.tipo, m.descripcion, cm.fecha_inicio, cm.fecha_fin, cm.estado
    FROM clientes_membresias cm
    JOIN membresias m ON cm.id_membresia = m.id_membresia
    WHERE cm.id_cliente = ? AND cm.estado = 'Activa'
    ORDER BY cm.fecha_fin DESC
    LIMIT 1";

$stmt_membresia = $conn->prepare($sql_membresia);
$stmt_membresia->bind_param("i", $id_cliente);
$stmt_membresia->execute();
$membresia = $stmt_membresia->get_result()->fetch_assoc();

$dias_restantes = 0;
$progreso_porcentaje = 0;
if ($membresia) {
    $fecha_fin = new DateTime($membresia['fecha_fin']);
    $fecha_inicio = new DateTime($membresia['fecha_inicio']);
    $hoy = new DateTime();
    
    if ($hoy < $fecha_fin) {
        $dias_restantes = $hoy->diff($fecha_fin)->days;
    }

    $duracion_total = $fecha_inicio->diff($fecha_fin)->days;
    $dias_transcurridos = $fecha_inicio->diff($hoy)->days;
    if ($duracion_total > 0) {
        $progreso_porcentaje = ($dias_transcurridos / $duracion_total) * 100;
        if ($progreso_porcentaje > 100) $progreso_porcentaje = 100;
    }
}

$sql_clases = "
    SELECT id_asistencia, clase, dia, hora, fecha
    FROM asistencia
    WHERE id_cliente = ?
    ORDER BY fecha ASC";
$stmt_clases = $conn->prepare($sql_clases);
$stmt_clases->bind_param("i", $id_cliente);
$stmt_clases->execute();
$clases = $stmt_clases->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Volumen de Hierro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="panel_styles.css"> 
</head>
<body>
    <div class="panel-container">
        <header class="panel-header">
            <div class="header-welcome">
                <img src="../../img/logo.png" alt="Logo" class="logo">
                <div>
                    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></h1>
                    <p>Aquí tienes el resumen de tu actividad.</p>
                </div>
            </div>
            <a href="../../backend/auth/logout.php" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </header>

        <main class="dashboard-grid">
            <?php if ($membresia): ?>
                <section class="card membership-card">
                    <div class="card-header">
                        <i class="bi bi-star-fill"></i>
                        <h2>Tu Membresía</h2>
                    </div>
                    <div class="membership-details">
                        <h3>Plan <?php echo htmlspecialchars($membresia['tipo']); ?></h3>
                        <p class="status <?php echo strtolower($membresia['estado']); ?>"><?php echo htmlspecialchars($membresia['estado']); ?></p>
                        <p class="description"><?php echo htmlspecialchars($membresia['descripcion']); ?></p>
                    </div>
                    <div class="membership-progress">
                        <div class="dates">
                            <span><strong>Inicio:</strong> <?php echo date("d/m/Y", strtotime($membresia['fecha_inicio'])); ?></span>
                            <span><strong>Vence:</strong> <?php echo date("d/m/Y", strtotime($membresia['fecha_fin'])); ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo $progreso_porcentaje; ?>%;"></div>
                        </div>
                    </div>
                </section>

                <section class="card stat-card">
                     <i class="bi bi-calendar-check"></i>
                    <div class="stat-info">
                        <p>Días Restantes</p>
                        <span><?php echo $dias_restantes; ?></span>
                    </div>
                </section>

                <section class="card stat-card">
                    <i class="bi bi-card-checklist"></i>
                    <div class="stat-info">
                        <p>Clases Reservadas</p>
                        <span><?php echo $clases->num_rows; ?></span>
                    </div>
                </section>

            <?php else: ?>
                <section class="card no-membership-alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <h2>No tienes una membresía activa</h2>
                    <p>Tu acceso a las instalaciones y clases está limitado. ¡Visita la recepción para activar o renovar tu plan y no te pierdas de nada!</p>
                    <a href="membresias.php" class="btn-primary">Ver y Comprar Planes</a>
                </section>
            <?php endif; ?>
        </main>
        
        <section class="card clases-section">
            <div class="card-header">
                <i class="bi bi-calendar3"></i>
                <h2>Tus Próximas Clases</h2>
            </div>
            <?php if ($clases->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="clases-table">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Día y Hora</th>
                                <th>Fecha de Reserva</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = $clases->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['clase']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['dia']); ?> a las <?php echo htmlspecialchars($fila['hora']); ?></td>
                                    <td><?php echo date("d/m/Y H:i", strtotime($fila['fecha'])); ?></td>
                                    <td>
                                        <form method="POST" action="cancelar_clase.php" class="form-cancelar">
                                            <input type="hidden" name="id_asistencia" value="<?php echo $fila['id_asistencia']; ?>">
                                            <button type="submit" class="btn-cancelar"
                                                data-clase="<?php echo htmlspecialchars($fila['clase']); ?>"
                                                data-dia="<?php echo htmlspecialchars($fila['dia']); ?>"
                                                data-hora="<?php echo htmlspecialchars($fila['hora']); ?>">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-clases-alert">
                    <i class="bi bi-calendar-x"></i>
                    <p>No tienes clases reservadas por el momento.</p>
                    <a href="../asistencia.html" class="btn-secondary">¡Reserva una ahora!</a>
                </div>
            <?php endif; ?>
        </section>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);

        if (params.get("login") === "success") {
            Swal.fire({
                icon: "success", title: "¡Bienvenido de nuevo!",
                text: "Has iniciado sesión como <?php echo addslashes($_SESSION['user_nombre']); ?>.",
                timer: 2500, showConfirmButton: false
            });
        }
        
        if (params.get("compra") === "exito") {
            Swal.fire({
                icon: "success", title: "¡Compra Exitosa!",
                text: "Tu nueva membresía ha sido activada correctamente. ¡A entrenar!",
                confirmButtonText: "¡Genial!", confirmButtonColor: "#28a745"
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }

        document.querySelectorAll(".form-cancelar").forEach(form => {
            form.addEventListener("submit", function(e) {});
        });
        if (params.get("cancel") === "ok") {}
        if (params.get("cancel") === "error") {}
    });
</script>
</body>
</html>