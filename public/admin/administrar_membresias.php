<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Membresías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos para los resultados de la búsqueda */
        #search_results { border: 1px solid #ddd; max-height: 200px; overflow-y: auto; }
        .search-item { padding: 10px; cursor: pointer; }
        .search-item:hover { background-color: #f0f0f0; }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="index.php" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver al Panel</a>
    <h1><i class="bi bi-star-fill"></i> Asignar Membresías a Clientes</h1>

    <div class="card shadow-sm mb-5">
        <div class="card-header"><h4>Asignar Nueva Membresía</h4></div>
        <div class="card-body">
            <form action="../../backend/membresias/asignar.php" method="POST">
                <div class="row">
                    <!-- NUEVO BUSCADOR DE CLIENTES -->
                    <div class="col-md-4 mb-3">
                        <label for="cliente_search" class="form-label">Buscar Cliente</label>
                        <input type="text" id="cliente_search" class="form-control" placeholder="Escriba nombre o apellido..." autocomplete="off">
                        <!-- Contenedor para los resultados -->
                        <div id="search_results"></div>
                        <!-- Input oculto que guardará el ID del cliente seleccionado -->
                        <input type="hidden" name="id_cliente" id="id_cliente_hidden" required>
                    </div>

                    <!-- DESPLEGABLE DE MEMBRESÍAS (SE MANTIENE) -->
                    <div class="col-md-4 mb-3">
                        <label for="id_membresia" class="form-label">Tipo de Membresía</label>
                        <select name="id_membresia" class="form-select" required>
                             <option value="">Seleccione una membresía...</option>
                             <?php
                            include '../../backend/config/database.php';
                            $membresiasSql = "SELECT id_membresia, tipo FROM Membresias";
                            $membresiasResult = $conn->query($membresiasSql);
                            while($membresia = $membresiasResult->fetch_assoc()) {
                                echo "<option value='{$membresia['id_membresia']}'>" . htmlspecialchars($membresia['tipo']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Asignar Membresía</button>
            </form>
        </div>
    </div>
    
    <?php $conn->close(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('cliente_search');
    const resultsContainer = document.getElementById('search_results');
    const hiddenInput = document.getElementById('id_cliente_hidden');

    searchBox.addEventListener('keyup', async function() {
        const query = searchBox.value;
        resultsContainer.innerHTML = ''; 
        hiddenInput.value = '';

        if (query.length < 2) {
            return;
        }

        const response = await fetch(`../../backend/clientes/buscar.php?query=${encodeURIComponent(query)}`);
        const clientes = await response.json();

  
        clientes.forEach(cliente => {
            const item = document.createElement('div');
            item.className = 'search-item';
            item.textContent = `${cliente.nombre} ${cliente.apellido}`;
            item.dataset.id = cliente.id_cliente; 
            resultsContainer.appendChild(item);

            item.addEventListener('click', function() {
                searchBox.value = this.textContent; 
                hiddenInput.value = this.dataset.id; 
                resultsContainer.innerHTML = '';
            });
        });
    });
});
</script>
</body>
</html>