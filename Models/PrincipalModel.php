<?php
class PrincipalModel extends Query {
    public function __construct() {
        parent::__construct();
    }

    // Método para obtener un usuario por correo
    public function getUsuario($correo) {
        return $this->select("SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1");
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $correo) {
        $sql = "INSERT INTO usuarios (nombre, correo, estado) VALUES (?, ?, 1)";
        $this->insertar($sql, [$nombre, $correo]);
    }

    public function licencia($nlicencia) {
    $db = new mysqli('localhost', 'root', '', 'licencias');
    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }
    $sql = "SELECT Fecha_registro FROM licencias WHERE Numero = '$nlicencia'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Fecha_registro'] > date('Y-m-d')) {
            $a = 1;
        } else {
            $a = 2;
        }
    } else {
        $a = 3; // No se encontró la licencia
    }
    $db->close();
    return $a;
    }
}
