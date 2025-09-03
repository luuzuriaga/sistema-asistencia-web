<?php
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema de Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }
        .sidebar .nav-link:hover {
            color: white;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-3">
                    <img src="../public/images/logo1.png" alt="Logo" class="img-fluid mb-3">
                    <h5 class="text-center">Panel de Administración</h5>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link py-3" href="index.php">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link py-3" href="empleados.php">
                        <i class="fas fa-users me-2"></i> Empleados
                    </a>
                    <a class="nav-link py-3" href="usuarios.php">
                        <i class="fas fa-user-cog me-2"></i> Usuarios
                    </a>
                    <a class="nav-link py-3" href="cargos.php">
                        <i class="fas fa-briefcase me-2"></i> Cargos
                    </a>
                    <a class="nav-link py-3" href="reportes.php">
                        <i class="fas fa-chart-bar me-2"></i> Reportes
                    </a>
                    <a class="nav-link py-3" href="../public/index.php">
                        <i class="fas fa-sign-in-alt me-2"></i> Registro Asistencia
                    </a>
                    <a class="nav-link py-3" href="../controlador/controlador_logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <div class="col-md-10">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <span class="navbar-brand">Sistema de Control de Asistencia</span>
                        <div class="d-flex">
                            <span class="navbar-text me-3">
                                Bienvenido, <?php echo $_SESSION['nombre']; ?>
                            </span>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid p-4">