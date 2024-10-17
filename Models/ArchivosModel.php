<?php
class ArchivosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getarchivos($id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE a.id_usuario = $id_usuario ORDER BY a.id DESC";
        return $this->selectAll($sql);
    }



}
