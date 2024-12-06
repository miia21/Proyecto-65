<?php
    require_once( '../php/autoload.php' );

    $pacienteObj = new Paciente();
    $paciente = $pacienteObj->getPaciente($_GET['id']);
    $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
    $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

    $medicamentos = $pacienteObj->getMedicamentosPorPaciente($_GET['id'], $fecha_inicio, $fecha_fin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Paciente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <div class="icono">
                    <a class="navbar-brand" href="index.php"><i class="bi bi-heart-pulse"></i></a>
                </div>
                <div class="nombre">
                    <a class="navbar-brand" href="index.php">Proyecto +65</a>
                </div>                
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4">Datos del Paciente</h2>
        <div class="datos container mb-3 p-3">
            <div class="row mt-2">
                <div class="item col">
                    <h4>Nombre:</h4>
                    <p class="datos-paciente"><?php echo $paciente['nombre'] ?></p>
                </div>
                <div class="item col">
                    <h4>Apellido:</h4>
                    <p class="datos-paciente"><?php echo $paciente['apellido'] ?></p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="item col">
                    <h4>Fecha de Nacimiento:</h4>
                    <p class="datos-paciente"><?php echo $paciente['fecha_nacimiento'] ?></p>
                </div>
                <div class="item col">
                    <h4>Celular:</h4>
                    <p class="datos-paciente"><?php echo $paciente['celular'] ?></p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="item col">
                    <h4>Genero:</h4>
                    <p class="datos-paciente"><?php echo $paciente['genero'] ?></p>
                </div>
                <div class="item col">
                    <h4>Departamento:</h4>
                    <p class="datos-paciente"><?php echo $paciente['nombre_departamento'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-end mt-4">
        <button class="btn deta" id="btnFiltro">Filtrar por fecha</button>
    </div>

    <div id="filtroFecha" style="display: none;" class="container mt-3">
        <div class="d-flex justify-content-center">
            <form action="" method="GET">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

                <label for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : ''; ?>" required>

                <label for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : ''; ?>" required>

                <button type="submit" class="btn deta">Aplicar Filtro</button>
            </form>
        </div>
    </div>

    <div class="container mt-5">
        <div>
            <h4 class="mb-3">Medicamentos</h4>
            <div class="row">
                <?php if (!empty($medicamentos)): ?>
                    <?php foreach ($medicamentos as $medicamento): ?>
                        <div class="col-md-6 mb-4"> 
                            <div class="border p-3"> 
                                <strong><?php echo htmlspecialchars($medicamento['nombre_comercial']); ?></strong>
                                <br>Laboratorio: <?php echo htmlspecialchars($medicamento['laboratorio_titular']); ?>
                                <br>Dosis: <?php echo htmlspecialchars($medicamento['dosis']); ?>
                                <br>Frecuencia: <?php echo htmlspecialchars($medicamento['frecuencia']); ?>
                                <br>Fecha de Alta: <?php echo htmlspecialchars($medicamento['fecha_alta']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay medicamentos registrados para este paciente.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <a href="../php/reporte.php?id=<?php echo $_GET['id']; ?>&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>" class="btn deta">Exportar a PDF</a>
    </div>


    <footer>
        <a href="index.php" class="botonF">Volver a Medicos</a>
    </footer>
    <script>
        document.getElementById("btnFiltro").addEventListener("click", function() {
            var filtro = document.getElementById("filtroFecha");
            if (filtro.style.display === "none") {
                filtro.style.display = "block";
            } else {
                filtro.style.display = "none";
            }
        });
    </script>
</body>
</html>