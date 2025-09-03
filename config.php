<?php
// Configuración de la base de datos MySQL
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // contraseña de MySQL
define('DB_NAME', 'sis_asistencia');

// Configuración de la aplicación
define('APP_NAME', 'Sistema de Control de Asistencia');
define('APP_VERSION', '1.0.0');

// Iniciar sesión
session_start();

// Zona horaria
date_default_timezone_set('America/Lima');

// Mostrar errores (solo en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>