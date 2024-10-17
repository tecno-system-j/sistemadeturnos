<?php
class Formulario extends Controller {
    private $id_usuario;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
    }

    // Cargar la vista de creación de formularios
    public function index() {
        $data['title'] = 'Crear Formulario';
        $data['script'] = 'formulario.js'; // Script para manejar la creación del formulario
        $this->views->getView('formulario', 'crear', $data);
    }

    // Guardar el formulario creado
    public function guardarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombreFormulario = $_POST['nombre'];
            $campos = $_POST['campos'];

            $resultado = $this->model->crearFormulario($nombreFormulario, json_encode($campos));

            if ($resultado) {
                $res = array('tipo' => 'success', 'mensaje' => 'Formulario creado exitosamente.');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al crear el formulario.');
            }

            echo json_encode($res);
            die();
        }
    }
}
