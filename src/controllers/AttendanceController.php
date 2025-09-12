<?php
class AttendanceController {
    public function registerAttendance($dni, $time) {
        try {
            // Simulación de registro en DB (PA1)
            echo "Asistencia registrada para DNI $dni a las $time";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>