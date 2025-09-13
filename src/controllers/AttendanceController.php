<?php
class AttendanceController {
    public function registerAttendance($dni, $time) {
        try {
            // Simulación de registro en DB (PA1)
            if (empty($dni)) {
                throw new Exception("DNI no puede estar vacío");
            }
            echo "Asistencia registrada para DNI $dni a las $time";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Nueva función para simular un reporte
    public function generateReport($dni) {
        try {
            if (!is_numeric($dni)) {
                throw new Exception("DNI debe ser numérico");
            }
            echo "Reporte generado para DNI $dni";
        } catch (Exception $e) {
            echo "Error en reporte: " . $e->getMessage();
        }
    }
}
?>
// Vinculado a Issue #1