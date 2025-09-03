<?php
include_once 'conexion.php';

class Usuario {
    private $conn;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }
    
    public function validar($usuario, $password) {
        $usuario = $this->conn->real_escape_string($usuario);
        $password = md5($password);
        
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE usuario = ? AND password = ?");
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        return false;
    }
    
    public function listar() {
        $sql = "SELECT * FROM usuario ORDER BY apellido, nombre";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function crear($nombre, $apellido, $usuario, $password) {
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        $usuario = $this->conn->real_escape_string($usuario);
        $passwordHash = md5($password);
        
        $stmt = $this->conn->prepare("INSERT INTO usuario (nombre, apellido, usuario, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $apellido, $usuario, $passwordHash);
        return $stmt->execute();
    }
    
    public function actualizar($id, $nombre, $apellido, $usuario, $password = null) {
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        $usuario = $this->conn->real_escape_string($usuario);
        
        if ($password) {
            $passwordHash = md5($password);
            $stmt = $this->conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, usuario = ?, password = ? WHERE id_usuario = ?");
            $stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $passwordHash, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, usuario = ? WHERE id_usuario = ?");
            $stmt->bind_param("sssi", $nombre, $apellido, $usuario, $id);
        }
        return $stmt->execute();
    }
    
    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function existeUsuario($usuario, $excluirId = null) {
        $usuario = $this->conn->real_escape_string($usuario);
        
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
        if ($excluirId) {
            $sql .= " AND id_usuario != $excluirId";
        }
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }
    
    public function cambiarPassword($id, $nuevaPassword) {
        $passwordHash = md5($nuevaPassword);
        $stmt = $this->conn->prepare("UPDATE usuario SET password = ? WHERE id_usuario = ?");
        $stmt->bind_param("si", $passwordHash, $id);
        return $stmt->execute();
    }
    
    public function obtenerEstadisticas() {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}
?>