<?php
    ob_start();
?>

<?php
    require_once ('autoload.php');

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
    <title>PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .border {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Datos del Paciente</h2>
        <table>
            <tr>
                <td><strong>Nombre:</strong> <?php echo $paciente['nombre'] ?></td>
                <td><strong>Apellido:</strong> <?php echo $paciente['apellido'] ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Nacimiento:</strong> <?php echo $paciente['fecha_nacimiento'] ?></td>
                <td><strong>Celular:</strong> <?php echo $paciente['celular'] ?></td>
            </tr>
            <tr>
                <td><strong>Género:</strong> <?php echo $paciente['genero'] ?></td>
                <td><strong>Departamento:</strong> <?php echo $paciente['nombre_departamento'] ?></td>
            </tr>
        </table>

        <h3>Medicamentos</h3>
        <?php if (!empty($medicamentos)): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Nombre Comercial</th>
                    <th style="width: 25%;">Laboratorio</th>
                    <th style="width: 15%;">Dosis</th>
                    <th style="width: 18%;">Frecuencia</th>
                    <th style="width: 17%;">Fecha de Alta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicamentos as $medicamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($medicamento['nombre_comercial']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['laboratorio_titular']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['dosis']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['frecuencia']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['fecha_alta']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No hay medicamentos registrados para este paciente.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
    $html = ob_get_clean();
    require_once ('../admin/libreria/dompdf/autoload.inc.php');
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $opciones = $dompdf->getOptions();
    $opciones->setIsRemoteEnabled(true);
    $dompdf->setOptions($opciones);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('reporte.pdf', array('Attachment' => FALSE));

?>