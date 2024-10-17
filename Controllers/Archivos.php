<?php
class Archivos extends Controller
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
        $data['title'] = 'Archivos';
        $data['active'] = 'todos';
        $data['archivos'] = $this->model->getarchivos($this->id_usuario);
        $this->views->getView('archivos', 'index', $data);
        $archivos = $this->model->getarchivosRecientes($this->id_usuario);





        
        $carpetas = $this->model->getCarpetas($this->id_usuario);
        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['fecha'] = $this->time_ago(strtotime($carpetas[$i]['fecha_create']));
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
        }
        


        $data['carpetas'] = $carpetas;
        $this->views->getView('admin', 'home', $data);
    }
}
