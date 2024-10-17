<?php
class Inicio extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->checkSession();
    }

    private function checkSession()
    {
        /* if (!isset($_SESSION['rol']) || empty($_SESSION['nombre'])) {
            $data['title'] = "Error";
            $this->views->getView('inicio', 'error', $data);
            exit; // Asegúrate de no continuar con la ejecución después de redirigir
        } */
    }

    public function Index()
    {
        /* if ($_SESSION['rol'] == "0") {
            $data['title'] = 'Inicio';
            $data['script'] = 'inicio.js';
            $this->views->getView('inicio', 'index', $data);
        } else {
            $data['title'] = 'Inicio2';
            $data['script'] = 'inicio.js';
            $this->views->getView('inicio', 'indexusuarios', $data);
        } */

        if (isset($_SESSION['rol'])) {
            switch ($_SESSION['rol']) {
                case "0":
                    $data['title'] = 'Inicio';
                    $data['script'] = 'inicio.js';
                    $this->views->getView('inicio', 'index', $data);
                    break;
                case "1":
                    $data['title'] = 'Inicio';
                    $data['script'] = 'inicio.js';
                    $this->views->getView('inicio', 'indexusuarios', $data);
                    break;
                default:
                    $data['title'] = 'Error';
                    $this->views->getView('inicio', 'error', $data);
                    break;
            }
        } else {
            $data['title'] = 'Error';
            $this->views->getView('inicio', 'error', $data);
        }

        
    }
}
