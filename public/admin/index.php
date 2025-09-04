<!DOCTYPE html>
<html lang="es">

<head><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Volumen de Hierro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .text-center {
            text-align: center;
        }
        .mb-4 { margin-bottom: 2rem; }
        .mt-2 { margin-top: 0.5rem; }
        .lead { font-size: 1.2rem; color: #555; }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .col-md-4 {
            flex: 1 1 260px;
            max-width: 300px;
            min-width: 260px;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 6px 24px rgba(0,0,0,0.12);
        }
        .card-body {
            padding: 2rem 1.2rem;
        }
        .card-title {
            margin-top: 1.2rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }
        .card-text {
            color: #666;
            font-size: 1rem;
            margin-top: 0.7rem;
        }
        img {
            border-radius: 8px;
        }
        @media (max-width: 900px) {
            .row { gap: 1rem; }
            .col-md-4 { max-width: 100%; min-width: 220px; }
        }
        @media (max-width: 600px) {
            .container { padding: 8px; }
            .row { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-4">
            <img src="../../img/logo.png" alt="Logo" width="150">
            <h1 class="mt-2">Panel de Administración</h1>
            <p class="lead">Selecciona una sección para gestionar.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="empleados.php" class="card-link">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-people-fill" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title">Gestionar Empleados</h5>
                            <p class="card-text">Añadir, editar y eliminar empleados del sistema.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="clientes.php" class="card-link">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-person-badge" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title">Gestionar Clientes</h5>
                            <p class="card-text">Administrar la información de los clientes del gimnasio.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="membresias.php" class="card-link">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-tags-fill" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title">Gestionar Tipos de Membresía</h5>
                            <p class="card-text">Crear, editar y eliminar los planes del gimnasio.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="administrar_membresias.php" class="card-link">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-star-fill" style="font-size: 3rem; color: #ffc107;"></i>
                            <h5 class="card-title">Asignar Membresías</h5>
                            <p class="card-text">Asignar y ver las membresías activas de los clientes.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
