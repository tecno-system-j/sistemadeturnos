
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class Turnos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $turnos = $this->model->obtenerTurnosPorFecha(date('Y-m-d')); // Ejemplo: obtener turnos del día actual
        $data = [
            'title' => 'Listado de Turnos',
            'script' => 'turnos.js', // Asumiendo que existe un script para manejar la lógica de la lista
            'turnos' => $turnos
        ];
        $this->views->getView("turnos", "listar", $data);
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lógica para manejar la creación de un turno
            $fecha = $_POST['fecha'];
            $ocupacion = $_POST['ocupacion'];
            $horario = $_POST['horario'];

            if ($this->model->crearTurno($fecha, $ocupacion, $horario, $_SESSION['correo'])) { // Asumiendo un valor por defecto para el email del doctor
                header('Location: ' . BASE_URL . 'turnos');
            } else {
                // Manejar el error
            }
        } else {
            $data = [
                'title' => 'Crear Turno',
                'script' => 'crearTurno.js' // Asumiendo que existe un script para esta vista
            ];
            $this->views->getView("turnos", "crear", $data);
        }
    }

    public function asignar($id)
    {
        $medico = $_SESSION['nombre'] . (isset($_SESSION['apellido']) ? " " . $_SESSION['apellido'] : "");
        $estado = "2";
        $data = $this->model->asignar($id, $medico, $estado); // Asegúrate de que los parámetros sean correctos
        if ($data == 1) {
            
            $res = array('tipo' => 'success', 'mensaje' => 'Turno Asignado y correo enviado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al asignar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Turno Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function liberar($id)
    {
        $data = $this->model->liberar($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Turno Liberado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Liberar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarTurnosPorMes()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $mes = $data['mes']; // Formato esperado: YYYY-MM

        $resultado = $this->model->generarTurnosAutomaticosPorMes($mes);
        echo json_encode($resultado);
    }

    public function obtenerTurnos()
    {
        $mes = $_GET['mes'] ?? null; // Captura el mes desde la petición GET
        error_log("Mes recibido: " . $mes);  // Esto escribirá el mes en el log de errores de PHP
        $data = $this->model->getTurnos($mes);
        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                    <i class="material-symbols-outlined">edit</i>
                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                    <i class="material-symbols-outlined">delete</i>
                </a>
                </div>';
        } //Asumiendo que existe este método en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function obtenerMesesDisponibles()
    {
        $meses = $this->model->getMesesDisponibles();
        echo json_encode($meses, JSON_UNESCAPED_UNICODE);
    }

    

    public function obtenerTurnosdisponibles()
    {
        $mes = $_GET['mes'] ?? null; // Captura el mes desde la petición GET
        error_log("Mes recibido: " . $mes);
        $data = $this->model->getTurnosdisponibles($mes);
        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-info btn-sm" onclick="asignar(' . $data[$i]['id'] . ', \'' . $data[$i]['fecha'] . '\', \'' . $data[$i]['ocupacion'] . '\', \'' . $data[$i]['horario'] . '\')">
                    <i class="material-symbols-outlined">assignment_add</i> Asignar
                </a>
                </div>';
        } //Asumiendo que existe este método en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function obtenerTurnosasigandosnombre()
    {
        $mes = $_GET['mes'] ?? null; // Captura el mes desde la petición GET
        error_log("Mes recibido: " . $mes);
        $nombre = $_SESSION['nombre'] . (isset($_SESSION['apellido']) ? " " . $_SESSION['apellido'] : "");
        $data = $this->model->obtenerTurnosasigandosnombre($mes, $nombre);
        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                    <i class="material-symbols-outlined">delete</i> Liberar
                </a>
                </div>';
        } //Asumiendo que existe este método en el modelo
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function ver()
    {
        $data = [
            'title' => 'Listado de Turnos Disponibles',
            'script' => 'turnosver.js', // Asumiendo que existe un script para manejar la lógica de la lista
        ];
        $this->views->getView("turnos", "ver", $data);
    }


    public function enviarcorreo(){
        $fecha_turno = $_POST['fecha'];
        $ocupacion = $_POST['ocupacion'];
        $horario = $_POST['horario'];

        

        $medico = $_SESSION['nombre'] . (isset($_SESSION['apellido']) ? " " . $_SESSION['apellido'] : ""); 

        $correo = $_SESSION['correo'];
            $mensaje = "
                <html>
                <head>
                    <link rel='stylesheet' type='text/css' href='http://filetech.rf.gd/Style.css'>
                </head>
                <body>
                    <table><tr><td>
                    <div style=\"border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px\" align=\"center\">
                        <img src=\"http://filetech.rf.gd/logo.png\" width=\"100\" height=\"24\" aria-hidden=\"true\" style=\"margin-bottom:16px\" alt=\"CentralHub\">
                        <div style=\"font-family:'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word\">
                            <div style=\"font-size:24px\">Confirmación de asignación de turno</div>
                        </div>
                        <div style=\"font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:center\">
                            <p>Estimado $medico </p> 
                            <p>Le informamos que se le ha asignado exitosamente el siguiente turno:</p>
                            <ul>
                                <li><strong>Fecha:</strong> $fecha_turno</li>
                                <li><strong>Ocupación:</strong> $ocupacion</li>
                                <li><strong>Horario:</strong> $horario</li>
                            </ul>
                            <p>Por favor, esté atento a cualquier otra actualización en su calendario de turnos.</p>
                            <p>Saludos,<br>CentralHub</p>
                        </div>
                        <div style=\"padding-top:20px;font-size:12px;line-height:16px;color:#5f6368;letter-spacing:0.3px;text-align:center\">
                            Este es un mensaje automático enviado por CentralHub
                        </div>
                    </div>
                    </td></tr></table>
                </body>
                </html>
            ";

            $subject = "Asignacion de Turno";


            // Lógica para enviar el correo
            // Aquí puedes usar PHPMailer o cualquier otra librería para enviar el correo
            // Ejemplo con PHPMailer:
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'morcillo.juliand10@gmail.com';
                $mail->Password = 'egmo xcec eaec llkv';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Destinatarios
                $mail->setFrom('morcillo.juliand10@gmail.com', 'CentralHub');
                $mail->addAddress($correo);

                // Contenido del correo
                $mail->isHTML(true); // Enviar como texto plano
                $mail->Subject = $subject;
                $mail->Body = $mensaje;

                $mail->send();
                $res = array('tipo' => 'warning', 'mensaje' => $mail->ErrorInfo, 'correo' => $correo);
            } catch (Exception $e) {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al enviar el correo: ' . $mail->ErrorInfo);
            }
    }
}
