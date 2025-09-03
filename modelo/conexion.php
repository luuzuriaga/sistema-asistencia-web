<?php
class Conexion {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;
    
    public function __construct() {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;
    }
    
    public function conectar() {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            
            if ($this->conn->connect_error) {
                throw new Exception("Error de conexión MySQL: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8");
            return $this->conn;
            
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function cerrar() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    // Método para verificar la conexión
    public function verificarConexion() {
        try {
            $conn = $this->conectar();
            if ($conn) {
                echo "✅ Conexión MySQL exitosa";
                $this->cerrar();
                return true;
            }
        } catch (Exception $e) {
            echo "❌ Error de conexión: " . $e->getMessage();
            return false;
        }
    }
}

// Script para probar la conexión
if (isset($_GET['testdb'])) {
    require_once '../config.php';
    $conexion = new Conexion();
    $conexion->verificarConexion();
    exit();
}
?>