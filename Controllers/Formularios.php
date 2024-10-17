<?php
class Formularios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
        }
    }

    public function index()
    {
        $data['title'] = 'Lista de Formularios';
        $data['formularios'] = $this->model->getFormularios();
        $data['script'] = 'formulario.js';

        $this->views->getView("formulario", "index", $data);
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            if (empty($nombre) || empty($descripcion)) {
                $res = array('tipo' => 'error', 'mensaje' => 'Todos los campos son obligatorios');
            } else {
                $this->model->crearFormulario($nombre, $descripcion);
                $res = array('tipo' => 'success', 'mensaje' => 'Formulario creado exitosamente');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }

        $data['title'] = 'Crear Formulario';
        $data['script'] = 'formularioscrear.js';
        $this->views->getView("formulario", "crear", $data);
    }

    public function editar($id)
    {
        // Si todo está bien, pasar los datos a la vista
        $data['title'] = 'Editar Formulario';
        $data['script'] = 'formularioseditar.js';
        $this->views->getView("formulario", "editar", $data);
    }

    public function editarform($id)
    {
        // Obtener los datos del formulario por su ID
        $formulario = $this->model->getFormularioById($id);

        if ($formulario) {
            echo json_encode($formulario, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'mensaje' => 'Formulario no encontrado'], JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    public function eliminar($id)
    {
        $this->model->eliminarFormulario($id);
        $res = array('tipo' => 'success', 'mensaje' => 'Formulario eliminado correctamente');
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_formulario = $_POST['idform'];
            $nombreFormulario = $_POST['nombreFormulario'];
            $descripcion = $_POST['descripcion'];

            // Campos dinámicos enviados desde el formulario
            $labels = $_POST['campo_label'] ?? [];
            $tipos = $_POST['campo_tipo'] ?? [];
            $nombres = $_POST['campo_nombre'] ?? [];
            $placeholders = $_POST['campo_placeholder'] ?? [];
            $requireds = $_POST['campo_required'] ?? [];

            // Validar que los campos no estén vacíos
            if (empty($nombreFormulario) || empty($descripcion)) {
                $res = array('tipo' => 'error', 'mensaje' => 'El nombre y la descripción son obligatorios');
            } else {
                // Actualizar el formulario
                $this->model->actualizarFormulario($id_formulario, $nombreFormulario, $descripcion);

                // Actualizar los campos del formulario
                $campos = [];
                for ($i = 0; $i < count($labels); $i++) {
                    $campos[] = [
                        'label' => $labels[$i],
                        'tipo' => $tipos[$i],
                        'nombre' => $nombres[$i],
                        'placeholder' => $placeholders[$i],
                        'required' => isset($requireds[$i]) ? 1 : 0
                    ];
                }

                // Guardar los campos en la base de datos
                $this->model->actualizarCamposFormulario($id_formulario, $campos);

                $res = array('tipo' => 'success', 'mensaje' => 'Formulario actualizado exitosamente');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    // Función para mostrar el formulario para responder
    public function verformulario($id)
    {
        $formulario = $this->model->getFormularioById($id);
        if ($formulario) {
            echo json_encode($formulario, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'mensaje' => 'Formulario no encontrado'], JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    public function ver($id)
    {
        // Si todo está bien, pasar los datos a la vista
        $data['title'] = 'Responder Formulario';
        $data['script'] = 'verformulario.js';
        $this->views->getView("formulario", "ver", $data);
    }

    // Función para registrar respuestas del formulario
    public function registrarrespuestas()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_formulario = $_POST['idform'];
            $respuestas = $_POST['respuestas'];

            if (!empty($respuestas)) {
                // Guardar las respuestas del formulario
                foreach ($respuestas as $campo => $respuesta) {
                    $this->model->guardarRespuesta($id_formulario, $campo, $respuesta);
                }
                $res = array('tipo' => 'success', 'mensaje' => 'Respuestas registradas correctamente');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'No se han enviado respuestas');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function metricas($id)
    {
        $respuestas = $this->model->getRespuestasPorCampo($id);

        $labels = [];
        $data = [];
        $metrica = [];

        foreach ($respuestas as $respuesta) {
            $labels[] = $respuesta['campo'];
            $data[] = $respuesta['total_respuestas'];
            $metrica[] = [
                'campo' => $respuesta['campo'],
                'total_respuestas' => $respuesta['total_respuestas']
            ];
        }

        echo json_encode([
            'grafico' => ['labels' => $labels, 'data' => $data],
            'metrica' => $metrica
        ], JSON_UNESCAPED_UNICODE);
        die();
    }

    // Función para cargar las respuestas del formulario
    public function respuestas($id)
    {
        $respuestas = $this->model->getRespuestasFormulario($id);

        if ($respuestas) {
            echo json_encode($respuestas, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'mensaje' => 'No se encontraron respuestas'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function verTurnos($fecha)
    {
        $turnosDisponibles = $this->model->getTurnosDisponibles($fecha);
        echo json_encode($turnosDisponibles, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reservarTurno()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fecha = $_POST['fecha'];
            $ocupacion = $_POST['ocupacion'];
            $horario = $_POST['horario'];
            $doctorEmail = $_POST['doctor_email']; // Asegúrate de que el email del doctor se esté pasando correctamente

            // Verificar si el turno ya está ocupado
            $turnoExistente = $this->model->getTurno($fecha, $ocupacion, $horario);
            if ($turnoExistente) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'El turno ya está ocupado.'], JSON_UNESCAPED_UNICODE);
            } else {
                $this->model->crearTurno($fecha, $ocupacion, $horario, $doctorEmail);
                // Aquí envía el correo con el código de validación
                // enviarCorreo($doctorEmail, $codigo);

                echo json_encode(['tipo' => 'success', 'mensaje' => 'Turno reservado exitosamente.'], JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function turnosDisponibles($id_formulario) {
        $fecha = $_GET['fecha']; // Asumiendo que la fecha se envía como parámetro GET
        $turnos = $this->model->getTurnosDisponibles($fecha);
        echo json_encode($turnos);
    }

    public function registrarTurno() {
        $fecha = $_POST['fecha'];
        $ocupacion = $_POST['ocupacion'];
        $horario = $_POST['horario'];
        $doctorEmail = $_POST['doctorEmail'];
        $resultado = $this->model->registrarTurno($fecha, $ocupacion, $horario, $doctorEmail);
        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Turno registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Turno no disponible']);
        }
    }
}
