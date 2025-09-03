<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sis_asistencia');

// Configuración de la aplicación
define('APP_NAME', 'Sistema de Control de Asistencia');
define('APP_VERSION', '1.0.0');
define('APP_LOGO', 'vista/public/images/logo1.png');

// Configuración de reportes
define('REPORT_DIR', 'reportes/');

// Iniciar sesión
session_start();

// Zona horaria
date_default_timezone_set('America/Lima');
?>