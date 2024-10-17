<?php
class Usuarios extends Controller{
    public function __construct(){
        parent::__construct();
        session_start();
    }

    public function Index(){
        $data['title'] = 'Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios', 'index', $data);
    }

    // Mira este codigo en busca de errores
    public function listar(){
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['id'] == 1) {
                $data[$i]['acciones'] = 'Este Usuario no se puede modificar';
            }else{    
                $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                    <i class="material-symbols-outlined">edit</i>
                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                    <i class="material-symbols-outlined">delete</i>
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
        $id_usuario = $_POST['id_usuario'];

        if (
            empty($nombre) || empty($apellido) || empty($correo) || empty($telefono)
            || empty($direccion) || empty($clave) 
        ) {
            $res = array('tipo' => 'error', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($id_usuario == '') {
                // Comprobar si existen correo
                $verificarCorreo = $this->model->getVerificar('correo', $correo, 0);

                if (empty($verificarCorreo)) {
                    // Comprobar si existen Telefono
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, 0);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $data = $this->model->registrar($nombre, $apellido, $correo, $telefono, $direccion, $hash, $rol);

                        if ($data > 0) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Registro exitoso');
                            
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Registro fallido');
                        }
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'El telefono ya está registrado');
                    }
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'El correo ya está registrado');
                }

                ###Modificar
            } else {
                // Comprobar si existen correo
                $verificarCorreo = $this->model->getVerificar('correo', $correo, $id_usuario);

                if (empty($verificarCorreo)) {
                    // Comprobar si existen Telefono
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, $id_usuario);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id_usuario);

                        if ($data == 1) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Modificado exitoso');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Modificado fallido');
                        }
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'El telefono ya está registrado');
                    }
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'El correo ya está registrado');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id){
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id){
        $data = $this->model->getUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
