<?php
class FormularioModel extends Query {
    
    // Crear un formulario y almacenarlo en la base de datos
    public function crearFormulario($nombre, $campos) {
        $sql = "INSERT INTO formularios (nombre, campos) VALUES (?, ?)";
        $datos = array($nombre, $campos);
        return $this->insertar($sql, $datos);
    }

    // Obtener un formulario por su ID
    public function getFormulario($idFormulario) {
        $sql = "SELECT * FROM formularios WHERE id = ?";
        return $this->select($sql, array($idFormulario));
    }

    // Guardar respuestas enviadas a un formulario
    public function guardarRespuestaFormulario($idFormulario, $respuestas) {
        $sql = "INSERT INTO respuestas (id_formulario, respuestas) VALUES (?, ?)";
        return $this->insertar($sql, array($idFormulario, $respuestas));
    }
}
