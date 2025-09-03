<?php
include_once 'conexion.php';

class Empleado {
    private $conn;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }
    
    public function listar() {
        $sql = "SELECT e.*, c.nombre as cargo_nombre 
                FROM empleado e 
                INNER JOIN cargo c ON e.id_cargo = c.id_cargo 
                ORDER BY e.apellido, e.nombre";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM empleado WHERE id_empleado = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function obtenerPorDni($dni) {
        // Validar que el DNI tenga 8 dígitos
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            return false;
        }
        
        $stmt = $this->conn->prepare("SELECT * FROM empleado WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function crear($nombre, $apellido, $dni, $id_cargo) {
        // Validar DNI
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            return false;
        }
        
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        
        $stmt = $this->conn->prepare("INSERT INTO empleado (nombre, apellido, dni, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id_cargo);
        return $stmt->execute();
    }
    
    public function actualizar($id, $nombre, $apellido, $dni, $id_cargo) {
        // Validar DNI
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            return false;
        }
        
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        
        $stmt = $this->conn->prepare("UPDATE empleado SET nombre = ?, apellido = ?, dni = ?, id_cargo = ? WHERE id_empleado = ?");
        $stmt->bind_param("sssii", $nombre, $apellido, $dni, $id_cargo, $id);
        return $stmt->execute();
    }
    
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM empleado WHERE id_empleado = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>