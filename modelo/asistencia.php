<?php
include_once 'conexion.php';

class Asistencia {
    private $conn;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }
    
    public function registrarEntrada($id_empleado) {
        $fecha_actual = date('Y-m-d');
        
        // Verificar si ya tiene una entrada registrada hoy
        $sql = "SELECT * FROM asistencia 
                WHERE id_empleado = $id_empleado 
                AND DATE(entrada) = '$fecha_actual'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return false; // Ya tiene una entrada registrada hoy
        }
        
        $sql = "INSERT INTO asistencia (id_empleado, entrada) 
                VALUES ($id_empleado, NOW())";
        return $this->conn->query($sql);
    }
    
    public function registrarSalida($id_empleado) {
        $fecha_actual = date('Y-m-d');
        
        // Verificar si ya tiene una salida registrada hoy
        $sql = "SELECT * FROM asistencia 
                WHERE id_empleado = $id_empleado 
                AND DATE(entrada) = '$fecha_actual' 
                AND salida IS NULL";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows == 0) {
            return false; // No tiene una entrada sin salida
        }
        
        $sql = "UPDATE asistencia 
                SET salida = NOW() 
                WHERE id_empleado = $id_empleado 
                AND DATE(entrada) = '$fecha_actual' 
                AND salida IS NULL";
        return $this->conn->query($sql);
    }
    
    public function obtenerReporte($fecha_inicio = null, $fecha_fin = null) {
        if (!$fecha_inicio) $fecha_inicio = date('Y-m-01');
        if (!$fecha_fin) $fecha_fin = date('Y-m-d');
        
        $sql = "SELECT a.*, e.nombre, e.apellido, e.dni, c.nombre as cargo 
                FROM asistencia a 
                INNER JOIN empleado e ON a.id_empleado = e.id_empleado 
                INNER JOIN cargo c ON e.id_cargo = c.id_cargo 
                WHERE DATE(a.entrada) BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                ORDER BY a.entrada DESC";
        $result = $this->conn->query($sql);
        return $result;
    }
}
?>