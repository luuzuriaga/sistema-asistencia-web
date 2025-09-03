<?php
include '../../modelo/conexion.php';
include '../../controlador/controlador_registrar_asistencia.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia - I.E. Antonio Raimondi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <img src="../images/logo1.png" alt="Logo" class="mb-3">
        <h1>IE N° 2079 "ANTONIO RAIMONDI"</h1>
        <p id="fecha"><?= date('d/m/Y H:i:s') ?></p>
        <h3>REGISTRA TU ASISTENCIA</h3>

        <form method="POST">
            <div class="mb-3">
                <input type="number" class="form-control" name="dni" placeholder="Ingrese DNI" required>
            </div>
            <button type="submit" name="btnentrada" class="btn btn-success">ENTRADA</button>
            <button type="submit" name="btnsalida" class="btn btn-danger">SALIDA</button>
        </form>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info mt-3"><?= $mensaje ?></div>
        <?php endif; ?>
    </div>

    <script>
        setInterval(() => {
            let fecha = new Date();
            document.getElementById("fecha").textContent = fecha.toLocaleString();
        }, 1000);
    </script>
</body>
</html>