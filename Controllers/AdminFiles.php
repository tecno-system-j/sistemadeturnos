<?php
class AdminFiles extends Controller
{
    private $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
    }
    public function Index()
    {
        $data['title'] = 'Inicio';
        $data['script'] = 'files.js';
        $data['active'] = 'recientes';
        $data['archivos'] = $this->model->getarchivosRecientes($this->id_usuario);
        $carpetas = $this->model->getCarpetas($this->id_usuario);
        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['fecha'] = $this->time_ago(strtotime($carpetas[$i]['fecha_create']));
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
        }
        $archivos = $this->model->getarchivosRecientes($this->id_usuario);

        for ($i = 0; $i < count($archivos); $i++) {
            $archivos[$i]['fecha'] = $this->time_ago(strtotime($data['archivos'][$i]['fecha_create']));
            $archivos[$i]['color'] = substr(md5($archivos[$i]['id']), 0, 6);
        }


        $data['carpetas'] = $carpetas;
        $this->views->getView('admin', 'home', $data);
    }

    public function crearcarpeta()
    {

        $nombre = $_POST['nombre'];

        if (empty($nombre)) {
            $res = array('tipo' => "warning", 'mensaje' => 'Ingrese el nombre de la carpeta');
        } else {
            // Comprobar nombre
            $verificarNombre = $this->model->getVerificar('nombre', $nombre, $this->id_usuario, 0);
            if (empty($verificarNombre)) {
                $data = $this->model->crearcarpeta($nombre, $this->id_usuario);
                if ($data > 0) {
                    $path = 'Files/' . $nombre; // Define the path for the new folder
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true); // Create the directory if it doesn't exist
                    }
                    $res = array('tipo' => 'success', 'mensaje' => 'Carpeta Creada');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL CREAR CARPETA');
                }
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'LA CARPETA YA EXISTE');
            }

            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die;
        }
    }

    function time_ago($fecha)
    {
        $diferencia = time() - $fecha;
        if ($diferencia < 1) {
            return 'Justo ahora';
        }
        $condicion = array(
            12 * 30 * 24 * 60 * 60  => 'año',
            30 * 24 * 60 * 60 => 'mes',
            24 * 60 * 60 => 'dia',
            60 * 60 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );
        foreach ($condicion as $secs => $str) {
            $d = $diferencia / $secs;
            if ($d >= 1) {
                //redondear
                $t = round($d);
                return 'hace ' . $t . ' ' . $str . ($t > 1 ? 's' : '');
            }
        }
    }

    public function subirarchivo(){
        $id_carpeta = (empty($_POST['id_carpeta'])) ? 1 : $_POST['id_carpeta'];
        $nombrecarpeta = $_POST['nombrecarpeta'];
        $archivo = $_FILES['file'];
        $name = $archivo['name'];
        $tmp = $archivo['tmp_name'];
        $tipo = $archivo['type'];
        $size = $archivo['size'];
        $usuario = $this->id_usuario;
        $data = $this->model->subirArchivo($name, $tipo, $id_carpeta, $usuario, $size);

        if ($data > 0) {
            $destino = 'Files/';
            if (!file_exists($destino)) {
                mkdir($destino);
            }
            $carpeta = 'Files/' . $nombrecarpeta; // Define the path for the new folder
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true); // Create the directory if it doesn't exist
                    }
            move_uploaded_file($tmp, $carpeta . '/' . $name);
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo subido correctamente');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al subir archivo');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die;
    }

    public function ver($id_carpeta){
        $data['title'] = 'Lista de archivos';
        //$data['script'] = 'ver.js';
        $data['archivos'] = $this->model->getArchivos($id_carpeta, $this->id_usuario);
        $this->views->getView('admin', 'archivos', $data);
    }
}
