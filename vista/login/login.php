<?php
session_start();
include 'modelo/conexion.php';

if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = md5($_POST['password']); // Encriptación básica

    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>