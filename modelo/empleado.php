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
        $sql = "SELECT * FROM empleado WHERE id_empleado = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
    
    public function obtenerPorDni($dni) {
        $sql = "SELECT * FROM empleado WHERE dni = '$dni'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
    
    public function crear($nombre, $apellido, $dni, $id_cargo) {
        $sql = "INSERT INTO empleado (nombre, apellido, dni, id_cargo) 
                VALUES ('$nombre', '$apellido', '$dni', $id_cargo)";
        return $this->conn->query($sql);
    }
    
    public function actualizar($id, $nombre, $apellido, $dni, $id_cargo) {
        $sql = "UPDATE empleado 
                SET nombre = '$nombre', apellido = '$apellido', dni = '$dni', id_cargo = $id_cargo 
                WHERE id_empleado = $id";
        return $this->conn->query($sql);
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM empleado WHERE id_empleado = $id";
        return $this->conn->query($sql);
    }
}
?>