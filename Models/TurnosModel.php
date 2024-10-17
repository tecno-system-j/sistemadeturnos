<?php
class TurnosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearTurno($fecha, $ocupacion, $horario, $doctorEmail)
    {
        $sql = "INSERT INTO turnos (fecha, ocupacion, horario, doctor_email, estado) VALUES (?, ?, ?, ?, 1)";
        return $this->insertar($sql, [$fecha, $ocupacion, $horario, $doctorEmail]);
    }

    public function obtenerTurnosPorFecha($fecha)
    {
        $sql = "SELECT * FROM turnos WHERE fecha = ? AND estado = 1";
        return $this->selectAll($sql, [$fecha]);
    }

    public function actualizarTurno($id, $fecha, $ocupacion, $horario, $doctorEmail)
    {
        $sql = "UPDATE turnos SET fecha = ?, ocupacion = ?, horario = ?, doctor_email = ? WHERE id = ?";
        return $this->save($sql, [$fecha, $ocupacion, $horario, $doctorEmail, $id]);
    }

    public function delete($id)
    {
        $sql = "UPDATE turnos SET estado = ? WHERE id = ?";
        $datos = array(0, $id);
        return $this->save($sql, $datos);
    }

    public function liberar($id)
    {
        $sql = "UPDATE turnos SET estado = ? WHERE id = ?";
        $datos = array(1, $id);
        return $this->save($sql, $datos);
    }

    public function asignar($id, $medico, $estado) {
        $sql = "UPDATE turnos SET medico = :medico, estado = :estado WHERE id = :id"; // Asegúrate de que la consulta esté bien formada
        $params = [
            ':medico' => $medico,
            ':estado' => $estado,
            ':id' => $id
        ];
        return $this->save($sql, $params);
    }


    public function generarTurnosAutomaticos()
    {
        $ocupaciones = ['URG', 'URG2', 'PROG1', 'PROG2', 'PROG3', 'PROG4', 'PROG5', 'PROG6', 'RECU', 'INTER', 'CPA'];
        $horarios = [
            'AM' => '7AM - 1PM',
            'PM' => '1PM - 7PM',
            'NOCHE' => '7PM - 7AM'
        ];

        $fechaInicio = new DateTime('first day of January this year');
        $fechaFin = new DateTime('last day of December this year');

        while ($fechaInicio <= $fechaFin) {
            foreach ($ocupaciones as $ocupacion) {
                foreach ($horarios as $periodo => $horario) {
                    $sql = "INSERT INTO turnos (fecha, ocupacion, horario, estado) VALUES (?, ?, ?, 1)";
                    $this->insertar($sql, [$fechaInicio->format('Y-m-d'), $ocupacion, $horario]);
                }
            }
            $fechaInicio->modify('+1 day');
        }
    }

    public function generarTurnosAutomaticosPorMes($mes)
    {
        $fechaInicio = new DateTime($mes . '-01');
        $fechaFin = clone $fechaInicio;
        $fechaFin->modify('last day of this month');

        $ocupaciones = ['URG', 'URG2', 'PROG1', 'PROG2', 'PROG3', 'PROG4', 'PROG5', 'PROG6', 'RECU', 'INTER', 'CPA'];
        $horarios = [
            'AM' => '7AM - 1PM',
            'PM' => '1PM - 7PM',
            'NOCHE' => '7PM - 7AM'
        ];

        $turnosCreados = 0;

        while ($fechaInicio <= $fechaFin) {
            foreach ($ocupaciones as $ocupacion) {
                foreach ($horarios as $periodo => $horario) {
                    $sql = "INSERT INTO turnos (fecha, ocupacion, horario, estado) VALUES (?, ?, ?, 1)";
                    $params = [$fechaInicio->format('Y-m-d'), $ocupacion, $horario];
                    if ($this->insertar($sql, $params)) {
                        $turnosCreados++;
                    }
                }
            }
            $fechaInicio->modify('+1 day');
        }

        return ['tipo' => 'success', 'mensaje' => "Turnos generados correctamente: $turnosCreados turnos creados."];
    }

    public function getTurnos($mes = null)
    {
        $sql = "SELECT * FROM turnos WHERE estado = 1";
        $params = [];
        if ($mes) {
            $sql .= " AND MONTH(fecha) = ? AND YEAR(fecha) = ?";
            $params = [substr($mes, 5, 2), substr($mes, 0, 4)];  // Asegúrate de que los parámetros son correctos
        }
        return $this->selectAll($sql, $params);
    }

    public function getMesesDisponibles()
    {
        $sql = "SELECT DISTINCT DATE_FORMAT(fecha, '%Y-%m') AS mes FROM turnos WHERE estado = 1 ORDER BY mes DESC";
        return $this->selectAll($sql);
    }

    public function getTurnosdisponibles($mes = null)
    {
    /* 0: eliminado
    1: disponible
    2: asignado */
        
        $sql = "SELECT * FROM turnos WHERE estado = 1";
        $params = [];
        if ($mes) {
            $sql .= " AND MONTH(fecha) = ? AND YEAR(fecha) = ?";
            $params = [substr($mes, 5, 2), substr($mes, 0, 4)];  // Asegúrate de que los parámetros son correctos
        }
        return $this->selectAll($sql, $params);
    }

    public function obtenerTurnosasigandosnombre($mes = null, $nombre)
    {
    /* 0: eliminado
    1: disponible
    2: asignado */
        
        $sql = "SELECT * FROM turnos WHERE estado = 2 AND medico = '$nombre'";
        $params = [];
        if ($mes) {
            $sql .= " AND MONTH(fecha) = ? AND YEAR(fecha) = ?";
            $params = [substr($mes, 5, 2), substr($mes, 0, 4)];  // Asegúrate de que los parámetros son correctos
        }
        return $this->selectAll($sql, $params);
    }

    
}
