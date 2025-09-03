<?php
include_once '../modelo/empleado.php';
include_once '../modelo/asistencia.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnentrada']) || isset($_POST['btnsalida'])) {
        $dni = $_POST['dni'];
        
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
    }
}
?>