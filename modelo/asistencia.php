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
        $stmt = $this->conn->prepare("SELECT * FROM asistencia WHERE id_empleado = ? AND DATE(entrada) = ?");
        $stmt->bind_param("is", $id_empleado, $fecha_actual);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return false;
        }
        
        $stmt = $this->conn->prepare("INSERT INTO asistencia (id_empleado, entrada) VALUES (?, NOW())");
        $stmt->bind_param("i", $id_empleado);
        return $stmt->execute();
    }
    
    public function registrarSalida($id_empleado) {
        $fecha_actual = date('Y-m-d');
        
        // Verificar si ya tiene una salida registrada hoy
        $stmt = $this->conn->prepare("SELECT * FROM asistencia WHERE id_empleado = ? AND DATE(entrada) = ? AND salida IS NULL");
        $stmt->bind_param("is", $id_empleado, $fecha_actual);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            return false;
        }
        
        $stmt = $this->conn->prepare("UPDATE asistencia SET salida = NOW() WHERE id_empleado = ? AND DATE(entrada) = ? AND salida IS NULL");
        $stmt->bind_param("is", $id_empleado, $fecha_actual);
        return $stmt->execute();
    }
    
    public function obtenerReporte($fecha_inicio = null, $fecha_fin = null) {
        if (!$fecha_inicio) $fecha_inicio = date('Y-m-01');
        if (!$fecha_fin) $fecha_fin = date('Y-m-d');
        
        $stmt = $this->conn->prepare("SELECT a.*, e.nombre, e.apellido, e.dni, c.nombre as cargo 
                FROM asistencia a 
                INNER JOIN empleado e ON a.id_empleado = e.id_empleado 
                INNER JOIN cargo c ON e.id_cargo = c.id_cargo 
                WHERE DATE(a.entrada) BETWEEN ? AND ? 
                ORDER BY a.entrada DESC");
        $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>