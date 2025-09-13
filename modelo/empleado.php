<?php 
include_once 'conexion.php';

class Empleado {
    private $conexion_db; // Cambio: renombré $conn a $conexion_db
    private $tabla_empleados = 'empleado'; // Nuevo: agregué propiedad para nombre de tabla
    
    public function __construct($config = null) { // Cambio: agregué parámetro opcional
        $conexion = new Conexion();
        $this->conexion_db = $conexion->conectar(); // Cambio: usar nuevo nombre de propiedad
        
        // Nuevo: configuración opcional
        if ($config && isset($config['tabla'])) {
            $this->tabla_empleados = $config['tabla'];
        }
    }
    
    // Nuevo método agregado al inicio
    public function validarConexion() {
        return $this->conexion_db !== null;
    }
    
    public function obtenerTodos() { // Cambio: renombré listar() a obtenerTodos()
        $consulta = "SELECT emp.*, cargo.nombre as nombre_cargo 
                    FROM {$this->tabla_empleados} emp 
                    INNER JOIN cargo ON emp.id_cargo = cargo.id_cargo 
                    ORDER BY emp.apellido ASC, emp.nombre ASC"; // Cambio: aliases diferentes y ASC explícito
        $resultado = $this->conexion_db->query($consulta);
        return $resultado;
    }
    
    public function buscarPorId($id_empleado) { // Cambio: renombré obtenerPorId() y parámetro
        $stmt = $this->conexion_db->prepare("SELECT * FROM {$this->tabla_empleados} WHERE id_empleado = ?");
        $stmt->bind_param("i", $id_empleado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    
    public function buscarPorDocumento($documento) { // Cambio: renombré método y parámetro
        // Cambio: validación más estricta del DNI
        if (strlen($documento) != 8 || !ctype_digit($documento)) {
            throw new InvalidArgumentException("El DNI debe tener exactamente 8 dígitos numéricos");
        }
        
        $stmt = $this->conexion_db->prepare("SELECT * FROM {$this->tabla_empleados} WHERE dni = ?");
        $stmt->bind_param("s", $documento);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    
    // Nuevo método agregado en el medio
    public function contarEmpleados() {
        $consulta = "SELECT COUNT(*) as total FROM {$this->tabla_empleados}";
        $resultado = $this->conexion_db->query($consulta);
        $fila = $resultado->fetch_assoc();
        return (int)$fila['total'];
    }
    
    public function registrar($datos) { // Cambio: renombré crear() y uso array de parámetros
        // Cambio: extraer datos del array
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';
        $dni = $datos['dni'] ?? '';
        $id_cargo = $datos['id_cargo'] ?? 0;
        
        // Cambio: validación más robusta
        if (empty($nombre) || empty($apellido) || empty($dni)) {
            throw new InvalidArgumentException("Todos los campos son obligatorios");
        }
        
        if (strlen($dni) != 8 || !ctype_digit($dni)) {
            throw new InvalidArgumentException("El DNI debe tener exactamente 8 dígitos");
        }
        
        // Cambio: verificar duplicados antes de insertar
        if ($this->buscarPorDocumento($dni)) {
            throw new InvalidArgumentException("Ya existe un empleado con ese DNI");
        }
        
        $nombre = $this->conexion_db->real_escape_string($nombre);
        $apellido = $this->conexion_db->real_escape_string($apellido);
        
        $stmt = $this->conexion_db->prepare("INSERT INTO {$this->tabla_empleados} (nombre, apellido, dni, id_cargo, fecha_registro) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id_cargo);
        return $stmt->execute();
    }
    
    public function modificar($id_empleado, $datos_nuevos) { // Cambio: renombré actualizar() y parámetros
        // Cambio: extraer datos del array
        $nombre = $datos_nuevos['nombre'] ?? '';
        $apellido = $datos_nuevos['apellido'] ?? '';
        $dni = $datos_nuevos['dni'] ?? '';
        $id_cargo = $datos_nuevos['id_cargo'] ?? 0;
        
        // Cambio: validación más estricta
        if (strlen($dni) != 8 || !ctype_digit($dni)) {
            throw new InvalidArgumentException("DNI inválido: debe tener 8 dígitos numéricos");
        }
        
        // Cambio: verificar que el empleado existe
        if (!$this->buscarPorId($id_empleado)) {
            throw new InvalidArgumentException("El empleado no existe");
        }
        
        $nombre = $this->conexion_db->real_escape_string($nombre);
        $apellido = $this->conexion_db->real_escape_string($apellido);
        
        $stmt = $this->conexion_db->prepare("UPDATE {$this->tabla_empleados} SET nombre = ?, apellido = ?, dni = ?, id_cargo = ?, fecha_modificacion = NOW() WHERE id_empleado = ?");
        $stmt->bind_param("sssii", $nombre, $apellido, $dni, $id_cargo, $id_empleado);
        return $stmt->execute();
    }
    
    public function borrar($id_empleado) { // Cambio: renombré eliminar()
        // Cambio: validar que existe antes de eliminar
        if (!$this->buscarPorId($id_empleado)) {
            return false;
        }
        
        $stmt = $this->conexion_db->prepare("DELETE FROM {$this->tabla_empleados} WHERE id_empleado = ?");
        $stmt->bind_param("i", $id_empleado);
        return $stmt->execute();
    }
    
    // Nuevo método agregado al final
    public function obtenerEstadisticas() {
        $consulta = "SELECT 
                        COUNT(*) as total_empleados,
                        COUNT(DISTINCT id_cargo) as total_cargos
                     FROM {$this->tabla_empleados}";
        $resultado = $this->conexion_db->query($consulta);
        return $resultado->fetch_assoc();
    }
    
    // Nuevo método de limpieza
    public function cerrarConexion() {
        if ($this->conexion_db) {
            $this->conexion_db->close();
        }
    }
}
?>