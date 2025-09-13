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
                ORDER BY e.nombre, e.apellido"; // CAMBIO AQUÍ: orden por nombre primero
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
        // CAMBIO: Validación diferente
        if (strlen($dni) != 8 || !ctype_digit($dni)) {
            return "DNI_INVALIDO"; // CAMBIO: retorno string en lugar de false
        }
        
        $stmt = $this->conn->prepare("SELECT * FROM empleado WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function crear($nombre, $apellido, $dni, $id_cargo) {
        // CAMBIO: Validación diferente
        if (strlen($dni) != 8 || !ctype_digit($dni)) {
            return "ERROR_DNI"; // CAMBIO: mensaje específico
        }
        
        $nombre = trim($this->conn->real_escape_string($nombre)); // CAMBIO: agregado trim
        $apellido = trim($this->conn->real_escape_string($apellido)); // CAMBIO: agregado trim
        
        $stmt = $this->conn->prepare("INSERT INTO empleado (nombre, apellido, dni, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id_cargo);
        return $stmt->execute();
    }
}
?>