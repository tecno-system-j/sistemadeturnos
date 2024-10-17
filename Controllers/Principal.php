<?php
require_once 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

header('Access-Control-Allow-Origin: *');

class Principal extends Controller {
    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function Index() {
        $data['title'] = 'Iniciar sesión';
        $this->views->getView('principal', 'index', $data);
    }

    public function validarlicencia($nlicencia) {
        $licencia = $this->model->licencia($nlicencia);
        return $licencia;
    }

    // Método para validar el inicio de sesión
    public function validar() {
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];

        $data = $this->model->getUsuario($correo);

        if (!empty($data)) {
            if (password_verify($clave, $data['clave'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['apellido'] = $data['apellido'];
                $_SESSION['rol'] = $data['rol'];
                $_SESSION['licencia'] = $data['licencia'];
                $nlicencia = $data['licencia'];
                $licencia = $this->validarlicencia($nlicencia);
                switch ($licencia) {
                    case '1':
                        $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido', 'licencaestado' => 'si');
                        // header('Location: ' . BASE_URL . 'inicio'); // Eliminar redirección
                        break;
                    
                    case '2':
                        $res = array('tipo' => 'warning', 'mensaje' => 'Licencia vencida', 'licencaestado' => 'no');
                        // header('Location: ' . BASE_URL); // Eliminar redirección
                        session_destroy();
                        break;

                    case '3':
                        $res = array('tipo' => 'warning', 'mensaje' => 'Licencia no encontrada', 'licencaestado' => 'no');
                        // header('Location: ' . BASE_URL); // Eliminar redirección
                        session_destroy();
                        break;
                        
                    default:
                        $res = array('tipo' => 'error', 'mensaje' => 'Error desconocido', 'licencaestado' => 'no'); // Manejo de error
                        break;
                }
                echo json_encode($res); // Enviar respuesta como JSON
                exit; // Asegurarse de que no se ejecute más código
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'Contraseña incorrecta');
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'El correo no está registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para iniciar sesión con Google
    public function loginGoogle() {
        $client = new Google_Client();
        $client->setClientId('1021010974150-5qv5e299lqs3vga282ja2pl0jshq34r7.apps.googleusercontent.com'); // Reemplaza con tu Client ID
        $client->setClientSecret('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'); // Reemplaza con tu Client Secret
        $client->setRedirectUri(BASE_URL . 'principal/callback'); // Asegúrate de que esta URL coincida con la registrada en Google Console
        $client->addScope('email');
        $client->addScope('profile');

        // Crear la URL de autenticación
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit();
    }

    // Método para manejar el callback de Google
    public function callback() {
        $client = new Google_Client();
        $client->setClientId('1021010974150-5qv5e299lqs3vga282ja2pl0jshq34r7.apps.googleusercontent.com'); // Reemplaza con tu Client ID
        $client->setClientSecret('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'); // Reemplaza con tu Client Secret
        $client->setRedirectUri(BASE_URL . 'principal/callback');

        if (isset($_GET['code'])) {
            // Intercambiar el código de autorización por el token de acceso
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (isset($token['access_token'])) {
                // Establecer el token de acceso en el cliente de Google
                $client->setAccessToken($token['access_token']);

                // Obtener la información del usuario autenticado
                $google_oauth = new Google_Service_Oauth2($client);
                $userInfo = $google_oauth->userinfo->get();

                // Verificar si el usuario ya existe en la base de datos
                $usuario = $this->model->getUsuario($userInfo->email);
                if (empty($usuario)) {
                    // Si no existe, registrarlo
                    $this->model->registrarUsuario($userInfo->name, $userInfo->email);
                    
                }
                // Almacenar la información del usuario en la sesión
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['rol'] = $usuario['rol'];
                $_SESSION['licencia'] = $usuario['licencia'];
                $nlicencia = $usuario['licencia'];
                $licencia = $this->validarlicencia($nlicencia);
                //validar licencia user authorized for google
                switch ($licencia) {
                    case '1':
                       $res = array( 'tipo' => 'success', 'mensaje' => 'Bienvenido', 'licencaestado' => 'si');
                        header('Location: ' . BASE_URL . 'inicio');
                        break;
                    
                    case '2':
                        $res = array('tipo' => 'warning', 'mensaje' => 'Licencia vencida','licencaestado' => 'no');
                        header('Location: ' . BASE_URL);                        
                       session_destroy();
                        break;
                    case '3':
                   $res = array('tipo' => 'warning', 'mensaje' => 'Licencia no encontrada','licencaestado' => 'no');
                   header('Location: ' . BASE_URL);
                       session_destroy();
                        break;
                        
                    default:
                        # code...
                        break;
                }


                // Redireccionar al panel de administración
                
                exit();
            } else {
                echo 'Error al obtener el token de acceso';
            }
        } else {
            echo 'Código de autorización no recibido';
        }
    }

    public function salir() {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

    public function usuario() {
        $correo = 'morcillo.juliand10@gmail.com';
        $usuario = $this->model->getUsuario($correo);
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
        die();

    }
    public function licencia() {
        $nlicencia = '1465-4568-1355-1234';
        $licencia = $this->model->licencia($nlicencia);
        echo json_encode($licencia, JSON_UNESCAPED_UNICODE);
        die();

    }
    


}
