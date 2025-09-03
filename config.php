<?php
// =============================
// Configuración de la base de datos MySQL
// =============================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sis_asistencia');

// =============================
// Configuración de la aplicación
// =============================
define('APP_NAME', 'Sistema de Control de Asistencia');
define('APP_VERSION', '1.0.0');

// =============================
// Sesiones
// =============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    session_regenerate_id(true);
}

// =============================
// Zona horaria
// =============================
date_default_timezone_set('America/Lima');

// =============================
// Errores (activar solo en desarrollo)
// =============================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =============================
// Token CSRF
// =============================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// =============================
// Función de logging
// =============================
function log_error($message) {
    $log_dir = __DIR__ . '/logs';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    $log_file = $log_dir . '/error.log';
    $timestamp = date('Y-m-d H:i:s');
    error_log("[$timestamp] $message\n", 3, $log_file);
}

// =============================
// Función de sanitización
// =============================
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>