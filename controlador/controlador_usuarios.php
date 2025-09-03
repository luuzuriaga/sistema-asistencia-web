<?php
include_once 'conexion.php';

class Usuario {
    private $conn;
    
    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }
    
    /**
     * Validar credenciales de usuario
     */
    public function validar($usuario, $password) {
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND password = '$password'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    
    /**
     * Obtener todos los usuarios
     */
    public function listar() {
        $sql = "SELECT * FROM usuario ORDER BY apellido, nombre";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    /**
     * Obtener usuario por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
    
    /**
     * Crear nuevo usuario
     */
    public function crear($nombre, $apellido, $usuario, $password) {
        $passwordHash = md5($password);
        $sql = "INSERT INTO usuario (nombre, apellido, usuario, password) 
                VALUES ('$nombre', '$apellido', '$usuario', '$passwordHash')";
        return $this->conn->query($sql);
    }
    
    /**
     * Actualizar usuario existente
     */
    public function actualizar($id, $nombre, $apellido, $usuario, $password = null) {
        if ($password) {
            $passwordHash = md5($password);
            $sql = "UPDATE usuario 
                    SET nombre = '$nombre', apellido = '$apellido', 
                        usuario = '$usuario', password = '$passwordHash' 
                    WHERE id_usuario = $id";
        } else {
            $sql = "UPDATE usuario 
                    SET nombre = '$nombre', apellido = '$apellido', usuario = '$usuario' 
                    WHERE id_usuario = $id";
        }
        return $this->conn->query($sql);
    }
    
    /**
     * Eliminar usuario
     */
    public function eliminar($id) {
        $sql = "DELETE FROM usuario WHERE id_usuario = $id";
        return $this->conn->query($sql);
    }
    
    /**
     * Verificar si el usuario ya existe
     */
    public function existeUsuario($usuario, $excluirId = null) {
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
        if ($excluirId) {
            $sql .= " AND id_usuario != $excluirId";
        }
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }
    
    /**
     * Cambiar contraseña
     */
    public function cambiarPassword($id, $nuevaPassword) {
        $passwordHash = md5($nuevaPassword);
        $sql = "UPDATE usuario SET password = '$passwordHash' WHERE id_usuario = $id";
        return $this->conn->query($sql);
    }
    
    /**
     * Obtener estadísticas de usuarios
     */
    public function obtenerEstadisticas() {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}
?>