<?php
include_once '../modelo/usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = md5($_POST['password']);
    
    $usuarioModel = new Usuario();
    $user = $usuarioModel->validar($usuario, $password);
    
    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apellido'];
        $_SESSION['id_usuario'] = $user['id_usuario'];
        
        header('Location: ../vista/dashboard/index.php');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>