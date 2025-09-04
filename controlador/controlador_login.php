<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../modelo/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token de seguridad inválido";
        header("Location: ../vista/login/login.php?error=" . urlencode($error));
        exit();
    }
    
    // Sanitizar entradas
    $usuario = sanitize_input($_POST['usuario']);
    $password = sanitize_input($_POST['password']);
    
    $usuarioModel = new Usuario();
    $user = $usuarioModel->validar($usuario, $password);
    
    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apellido'];
        $_SESSION['id_usuario'] = $user['id_usuario'];

        header('Location: ../vista/dashoboard/index.php');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
        header("Location: ../vista/login/login.php?error=" . urlencode($error));
        exit();
    }
}
?>