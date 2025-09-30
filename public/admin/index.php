<?php
session_start();

if (!isset($_SESSION['empleado_id'])) {
    header("Location: ../login.html");
    exit;
}
$user_nombre = $_SESSION['user_nombre'] ?? 'Usuario';
$user_tipo = $_SESSION['user_tipo'] ?? 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="index_styles.css">
</head>
<body>
    <div class="admin-container">
        <header class="dashboard-header">
            <div class="welcome-message">
                <h1>Bienvenido de nuevo, <span><?php echo htmlspecialchars($user_nombre); ?></span></h1>
                <p>Gestiona el gimnasio desde aquí. ¿Qué deseas hacer hoy?</p>
            </div>
            <a href="../../backend/auth/logout.php" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </header>

        <main class="dashboard-grid">
            
            <a href="clientes.php" class="nav-card admin-card">
                <i class="bi bi-people-fill card-icon"></i>
                <h3>Gestionar Clientes</h3>
                <p>Ver, agregar y editar la información de los clientes del gimnasio.</p>
                <span class="admin-only-tag">Solo Administrador</span>
            </a>

            <a href="empleados.php" class="nav-card admin-card">
                <i class="bi bi-person-badge card-icon"></i>
                <h3>Gestionar Empleados</h3>
                <p>Administrar el personal, sus roles y permisos en el sistema.</p>
                <span class="admin-only-tag">Solo Administrador</span>
            </a>

            <a href="membresias.php" class="nav-card admin-card">
                <i class="bi bi-tags-fill card-icon"></i>
                <h3>Planes de Membresía</h3>
                <p>Crear y editar los diferentes planes disponibles para los clientes.</p>
                <span class="admin-only-tag">Solo Administrador</span>
            </a>

            <a href="administrar_membresias.php" class="nav-card admin-card">
                <i class="bi bi-person-check-fill card-icon"></i>
                <h3>Asignar Membresías</h3>
                <p>Asignar planes a los clientes y consultar el historial de membresías.</p>
                <span class="admin-only-tag">Solo Administrador</span>
            </a>

            <a href="listado_asistencia.php" class="nav-card">
                <i class="bi bi-calendar-check card-icon"></i>
                <h3>Asistencia a Clases</h3>
                <p>Ver y gestionar los clientes inscritos en cada una de las clases grupales.</p>
            </a>
            
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      const userTipo = "<?php echo $user_tipo; ?>";

      const params = new URLSearchParams(window.location.search);
      if (params.get("login") === "success") {
        Swal.fire({
          icon: "success",
          title: "¡Bienvenido!",
          text: "Has iniciado sesión como <?php echo htmlspecialchars($user_nombre); ?>.",
          timer: 2500,
          showConfirmButton: false,
          position: 'top-end',
          toast: true
        });
      }

      document.querySelectorAll('.admin-card').forEach(card => {
        card.addEventListener('click', function(e) {
          if (userTipo !== 'Administrador') {
            e.preventDefault(); 
            Swal.fire({
              icon: 'error',
              title: 'Acceso Denegado',
              text: 'No tienes permisos de administrador para acceder a esta sección.',
              confirmButtonColor: '#dc3545'
            });
          }
        });
      });
    </script>
</body>
</html>