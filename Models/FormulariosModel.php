<?php
class FormulariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFormularios()
    {
        $sql = "SELECT id, nombre, descripcion FROM formularios WHERE estado = 1";
        return $this->selectAll($sql);
    }

    public function getFormularioById($id)
    {
        $sql = "SELECT id, nombre, descripcion FROM formularios WHERE id = ? AND estado = 1";
        $formulario = $this->select($sql, [$id]);

        if ($formulario) {
            $sqlCampos = "SELECT id, label, tipo, nombre, placeholder, required 
                          FROM campos_formulario 
                          WHERE id_formulario = ?";
            $formulario['campos'] = $this->selectAll($sqlCampos, [$id]);
        }

        return $formulario;
    }

    public function crearFormulario($nombre, $descripcion)
    {
        $sql = "INSERT INTO formularios (nombre, descripcion) VALUES (?, ?)";
        return $this->insertar($sql, [$nombre, $descripcion]);
    }

    public function actualizarFormulario($id, $nombre, $descripcion)
    {
        $sql = "UPDATE formularios SET nombre = ?, descripcion = ? WHERE id = ?";
        return $this->save($sql, [$nombre, $descripcion, $id]);
    }

    public function actualizarCamposFormulario($id_formulario, $campos)
    {
        // Eliminar los campos antiguos
        $sql = "DELETE FROM campos_formulario WHERE id_formulario = ?";
        $this->save($sql, [$id_formulario]);

        // Insertar los nuevos campos
        foreach ($campos as $campo) {
            $sql = "INSERT INTO campos_formulario (id_formulario, label, tipo, nombre, placeholder, required)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $this->insertar($sql, [
                $id_formulario,
                $campo['label'],
                $campo['tipo'],
                $campo['nombre'],
                $campo['placeholder'],
                $campo['required']
            ]);
        }
    }

    public function guardarRespuesta($id_formulario, $campo, $respuesta)
    {
        $sql = "INSERT INTO respuestas_formulario (id_formulario, campo, respuesta) VALUES (?, ?, ?)";
        return $this->insertar($sql, [$id_formulario, $campo, $respuesta]);
    }

    public function getRespuestasPorCampo($id_formulario)
    {
        $sql = "SELECT campo, COUNT(*) as total_respuestas 
                FROM respuestas_formulario 
                WHERE id_formulario = ?
                GROUP BY campo";
        return $this->selectAll($sql, [$id_formulario]);
    }

    public function getRespuestasFormulario($id_formulario)
    {
        $sqlCampos = "SELECT id, nombre FROM campos_formulario WHERE id_formulario = ?";
        $campos = $this->selectAll($sqlCampos, [$id_formulario]);

        $sqlRespuestas = "SELECT campo, respuesta FROM respuestas_formulario WHERE id_formulario = ?";
        $respuestas = $this->selectAll($sqlRespuestas, [$id_formulario]);

        // Organizar respuestas
        $respuestasAgrupadas = [];
        foreach ($respuestas as $respuesta) {
            $respuestasAgrupadas[$respuesta['campo']][] = $respuesta['respuesta'];
        }

        $resultado = [
            'campos' => $campos,
            'respuestas' => []
        ];

        $maxRespuestas = max(array_map('count', $respuestasAgrupadas));
        for ($i = 0; $i < $maxRespuestas; $i++) {
            $fila = [];
            foreach ($campos as $campo) {
                $fila[$campo['nombre']] = $respuestasAgrupadas[$campo['nombre']][$i] ?? '';
            }
            $resultado['respuestas'][] = $fila;
        }

        return $resultado;
    }

    public function getTurnosDisponibles($fecha)
    {
        // Aquí se pueden definir los horarios y ocupaciones
        $horarios = [
            'AM' => '7AM - 1PM',
            'PM' => '1PM - 7PM',
            'NOCHE' => '7PM - 7AM'
        ];

        $ocupaciones = ['URG', 'URG2', 'PROG1', 'PROG2', 'PROG3', 'PROG4', 'PROG5', 'PROG6', 'RECU', 'INTER', 'CPA'];
        $disponibles = [];

        foreach ($ocupaciones as $ocupacion) {
            foreach ($horarios as $tipo => $horario) {
                // Verificar si el turno ya está ocupado
                $sql = "SELECT COUNT(*) as total FROM turnos WHERE fecha = ? AND ocupacion = ? AND horario = ?";
                $total = $this->select($sql, [$fecha, $ocupacion, $tipo]);
                if ($total['total'] == 0) {
                    $disponibles[] = ['ocupacion' => $ocupacion, 'horario' => $horario, 'tipo' => $tipo];
                }
            }
        }

        return $disponibles;
    }

    public function crearTurno($fecha, $ocupacion, $horario, $doctorEmail)
    {
        $sql = "INSERT INTO turnos (fecha, ocupacion, horario, doctor_email) VALUES (?, ?, ?, ?)";
        return $this->insertar($sql, [$fecha, $ocupacion, $horario, $doctorEmail]);
    }

    public function verificarDisponibilidadTurno($fecha, $ocupacion, $horario) {
        $sql = "SELECT COUNT(*) as total FROM turnos WHERE fecha = ? AND ocupacion = ? AND horario = ?";
        $total = $this->select($sql, [$fecha, $ocupacion, $horario]);
        return $total['total'] == 0;
    }

    public function registrarTurno($fecha, $ocupacion, $horario, $doctorEmail) {
        if ($this->verificarDisponibilidadTurno($fecha, $ocupacion, $horario)) {
            $sql = "INSERT INTO turnos (fecha, ocupacion, horario, doctor_email) VALUES (?, ?, ?, ?)";
            return $this->insertar($sql, [$fecha, $ocupacion, $horario, $doctorEmail]);
        }
        return false;
    }
}
