<?php
    require_once( '../php/autoload.php' );

    $medicoObj = new Medico();
    $medicos = $medicoObj->getMedicos();

    $medicosConPacientes = [];
    foreach ($medicos as $medico) {
        $medico['pacientes'] = $medicoObj->getPacientesPorMedico($medico['id']);
        $medicosConPacientes[] = $medico;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto +65</title>
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

    <!-- Mejorar, si hay muchos datos en la base de datos puede ser una consulta muy grande -->

    <div class="container mt-5">
        <h2 class="inicio mb-4">Listado de Médicos y sus Pacientes</h2>
        <div class="accordion" id="accordionMedicos">
            <?php foreach ($medicosConPacientes as $index => $medico): ?>
            <div class="card">
                <div class="card-header" id="heading<?php echo $index; ?>">
                    <h2 class="mb-0">
                        <button class="btn medico fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="true" aria-controls="collapse<?php echo $index; ?>">
                            <?php echo "Dr/a. {$medico['nombre']} {$medico['apellido']} - {$medico['especialidad']} - {$medico['matricula']}"; ?>
                        </button>
                    </h2>
                </div>
                <div id="collapse<?php echo $index; ?>" class="collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $index; ?>" data-bs-parent="#accordionMedicos">
                    <div class="card-body">
                        <?php if (!empty($medico['pacientes'])): ?>
                            <ul>
                                <?php foreach ($medico['pacientes'] as $paciente): ?>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="nombre-paciente p-2">
                                            <strong><?php echo "{$paciente['nombre']} {$paciente['apellido']}"; ?></strong>
                                        </div>
                                        <a href="datosPacientes.php?id=<?php echo $paciente['id']; ?>" class="deta btn me-2"><i class="bi bi-clipboard2-pulse"></i> Ver detalles</a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No hay pacientes registrados para este médico.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <a href="" class="botonF">Volver al inicio</a>
    </footer>
</body>
</html>
