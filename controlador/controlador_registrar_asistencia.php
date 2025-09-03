<?php
include_once '../config.php';
include_once '../modelo/empleado.php';
include_once '../modelo/asistencia.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $mensaje = "Token de seguridad inválido";
        header("Location: ../public/index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
    
    if (isset($_POST['btnentrada']) || isset($_POST['btnsalida'])) {
        $dni = sanitize_input($_POST['dni']);
        
        // Validar DNI
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            $mensaje = "ERROR: El DNI debe tener 8 dígitos numéricos";
            header("Location: ../public/index.php?mensaje=" . urlencode($mensaje));
            exit();
        }
        
        $empleadoModel = new Empleado();
        $empleado = $empleadoModel->obtenerPorDni($dni);
        
        if ($empleado) {
            $asistenciaModel = new Asistencia();
            
            if (isset($_POST['btnentrada'])) {
                if ($asistenciaModel->registrarEntrada($empleado['id_empleado'])) {
                    $mensaje = "CORRECTO: Entrada registrada para " . $empleado['nombre'] . " " . $empleado['apellido'];
                } else {
                    $mensaje = "ERROR: Ya tiene una entrada registrada hoy";
                }
            } else {
                if ($asistenciaModel->registrarSalida($empleado['id_empleado'])) {
                    $mensaje = "CORRECTO: Salida registrada para " . $empleado['nombre'] . " " . $empleado['apellido'];
                } else {
                    $mensaje = "ERROR: No tiene una entrada registrada hoy";
                }
            }
        } else {
            $mensaje = "INCORRECTO: El DNI ingresado no existe";
        }
        
        header("Location: ../public/index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}
?>