<?php
session_start();
include 'modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = $_POST['dni'];
    $tipo = $_POST['tipo']; // 'entrada' o 'salida'

    $sql = "SELECT * FROM empleado WHERE dni = '$dni'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
        $id_empleado = $empleado['id_empleado'];

        if ($tipo == 'entrada') {
            $sql = "INSERT INTO asistencia (id_empleado, entrada) VALUES ($id_empleado, NOW())";
        } else {
            $sql = "UPDATE asistencia SET salida = NOW() WHERE id_empleado = $id_empleado AND salida IS NULL";
        }

        if ($conn->query($sql)) {
            echo "Registro exitoso.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "DNI no registrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Asistencia</title>
</head>
<body>
    <h1>Registro de Asistencia</h1>
    <form method="POST">
        <input type="text" name="dni" placeholder="Ingrese DNI" required>
        <button type="submit" name="tipo" value="entrada">Entrada</button>
        <button type="submit" name="tipo" value="salida">Salida</button>
    </form>
</body>
</html>