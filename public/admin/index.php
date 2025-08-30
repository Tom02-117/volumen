<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Volumen de Hierro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-link {
            text-decoration: none;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: all 0.2s;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <img src="../img/logo.png" alt="Logo" width="150">
            <h1 class="mt-2">Panel de Administración</h1>
            <p class="lead">Selecciona una sección para gestionar.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <a href="empleados.php" class="card-link">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-people-fill" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title mt-3">Gestionar Empleados</h5>
                            <p class="card-text">Añadir, editar y eliminar empleados del sistema.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="clientes.php" class="card-link">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-person-badge" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title mt-3">Gestionar Clientes</h5>
                            <p class="card-text">Administrar la información de los clientes del gimnasio.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="membresias.php" class="card-link">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-tags-fill" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title mt-3">Gestionar Tipos de Membresía</h5>
                            <p class="card-text">Crear, editar y eliminar los planes del gimnasio.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
        <a href="administrar_membresias.php" class="card-link">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-star-fill" style="font-size: 3rem; color: #ffc107;"></i>
                    <h5 class="card-title mt-3">Asignar Membresías</h5>
                    <p class="card-text">Asignar y ver las membresías activas de los clientes.</p>
                </div>
            </div>
        </a>
    </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>