<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function Index()
    {
        $data['title'] = 'Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios', 'index', $data);
    }
//mira este codigo en busca de errores
    public function listar(){
        $data = $this->model->getUsuarios();
        for ($i=0; $i < count($data) ; $i++) { 
            if ($data[$i]['id'] == 1) {
                $data [$i] ['acciones'] = 'Este Usuario no se puede modificar';
            }else {
                $data [$i] ['acciones'] = '<div>
            <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
               <i class="material-icons">edit</i>
            </a>
            <a href="#" class="btn btn-danger btn-sm" onclick="eliminar('.$data[$i]['id'].')">
               <i class="material-icons">delete</i>
            </a>
            </div>';
            }
            
            $data[$i]['nombres'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $clave = $_POST['clave'];
        $rol = $_POST['rol'];

        if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($clave) || empty($rol)) {
            $res = array('tipo' => 'error', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            // Comprobar si el correo ya está registrado
            $verficarCorreo = $this->model->getVerificar('correo', $correo);
            if (empty($verficarCorreo)) {
                // Comprobar si el teléfono ya está registrado
                $verficartel = $this->model->getVerificar('telefono', $telefono);
                if (empty($verficartel)) {
                    // Generar una clave secreta aleatoria para el cifrado simétrico
                    $clave_secreta = bin2hex(random_bytes(16));

                    // Cifrar la contraseña utilizando el cifrado simétrico
                    $cifrado = openssl_encrypt($clave, 'AES-128-CBC', $clave_secreta, 0, substr($clave_secreta, 0, 16));

                    // Guardar la información del usuario en la base de datos, incluyendo la clave secreta y el cifrado de la contraseña
                    $data = $this->model->guardar($nombre, $apellido, $correo, $telefono, $direccion, $clave_secreta, $cifrado, $rol);

                    if ($data > 0) {
                        $res = array('tipo' => 'success', 'mensaje' => 'Registro exitoso');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'Registro fallido');
                    }
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'El teléfono ya está registrado');
                }
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'El correo ya está registrado');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id){
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario Eliminado');
        }else{
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->getUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
