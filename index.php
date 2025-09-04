<?php
include_once (__DIR__ . "/config.php");
include_once (__DIR__ . "/controlador/controlador_registrar_asistencia.php");



// Mostrar mensaje si existe
$mensaje = isset($_GET['mensaje']) ? sanitize_input($_GET['mensaje']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Asistencia - I.E. Antonio Raimondi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vista/public/css/estilos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 text-center">
                <div class="imagen1 mb-3">
                    <img src="/vista/public/images/logo1.png" class="img-fluid" alt="Imagen institucional">
                </div>
                <div class="imagen2 mb-3">
                    <img src="/vista/public/images/logo2.png" class="img-fluid" alt="Logo institución">
                </div>
                
                <h1 class="mb-2">IE N° 2079 "ANTONIO RAIMONDI" 2025</h1>
                <h3 id="fecha" class="mb-4"><?php echo date("d/m/Y H:i:s"); ?></h3>
                
                <h3 class="mb-4">BIENVENIDO, REGISTRA TU ASISTENCIA</h3>
                
                <div class="card shadow">
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="mb-3">
                                <label for="txtdni" class="form-label"><b>Ingrese su DNI</b></label>
                                <input type="number" class="form-control form-control-lg" 
                                       placeholder="DNI del empleado" name="dni" id="txtdni" required
                                       min="10000000" max="99999999">
                            </div>
                            
                            <div class="d-grid gap-2 d-md-block">
                                <button id="Entrada" class="btn btn-success btn-lg me-md-2" 
                                        type="submit" name="btnentrada" value="ok">
                                    <b>ENTRADA</b>
                                </button>
                                <button id="Salida" class="btn btn-danger btn-lg" 
                                        type="submit" name="btnsalida" value="ok">
                                    <b>SALIDA</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <?php if (!empty($mensaje)): ?>
                <div class="alert alert-info mt-4">
                    <?php echo $mensaje; ?>
                </div>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="../vista/login/login.php" class="btn btn-outline-primary">Acceso Administrativo</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Actualizar fecha y hora en tiempo real
        setInterval(() => {
            let fecha = new Date();
            let fechahora = fecha.toLocaleString();
            document.getElementById("fecha").textContent = fechahora;
        }, 1000);
        
        // Limitar DNI a 8 caracteres
        let dni = document.getElementById("txtdni");
        dni.addEventListener("input", function() {
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8)
            }
        });
        
        // Eventos para la entrada y salida con el teclado
        document.addEventListener("keyup", function(event) {
            if (event.code == "ArrowLeft") {
                document.getElementById("Entrada").click()
            } else if (event.code == "ArrowRight") {
                document.getElementById("Salida").click()
            }
        });
        
        // Mostrar notificación si hay mensaje
        <?php if (!empty($mensaje)): ?>
        Swal.fire({
            title: '<?php echo (strpos($mensaje, "CORRECTO") !== false) ? "Éxito" : "Error"; ?>',
            text: '<?php echo $mensaje; ?>',
            icon: '<?php echo (strpos($mensaje, "CORRECTO") !== false) ? "success" : "error"; ?>',
            confirmButtonText: 'Aceptar'
        });
        <?php endif; ?>
    </script>
</body>
</html>