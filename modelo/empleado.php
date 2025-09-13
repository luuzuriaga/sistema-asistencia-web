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
                ORDER BY e.apellido DESC, e.nombre ASC"; // CAMBIO DIFERENTE: apellido descendente
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
        // CAMBIO DIFERENTE: Validación completamente distinta
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            return null; // CAMBIO DIFERENTE: retorno null en lugar de false
        }
        
        $stmt = $this->conn->prepare("SELECT * FROM empleado WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function crear($nombre, $apellido, $dni, $id_cargo) {
        // CAMBIO DIFERENTE: Validación completamente distinta
        if (strlen($dni) != 8 || !is_numeric($dni)) {
            return false; // CAMBIO DIFERENTE: retorno booleano
        }
        
        $nombre = strtoupper($this->conn->real_escape_string($nombre)); // CAMBIO DIFERENTE: mayúsculas
        $apellido = strtoupper($this->conn->real_escape_string($apellido)); // CAMBIO DIFERENTE: mayúsculas
        
        $stmt = $this->conn->prepare("INSERT INTO empleado (nombre, apellido, dni, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id_cargo);
        return $stmt->execute();
    }
}
?>