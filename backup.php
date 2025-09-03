<?php
include_once 'config.php';

$backup_dir = 'backup';
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

$backup_file = $backup_dir . '/' . DB_NAME . '_' . date('Y-m-d_H-i-s') . '.sql';
$command = "mysqldump --user=" . DB_USER . " --password=" . DB_PASS . " --host=" . DB_HOST . " " . DB_NAME . " > " . $backup_file;

system($command);

if (file_exists($backup_file)) {
    echo "Backup creado exitosamente: " . $backup_file;
} else {
    echo "Error al crear el backup";
}
?>