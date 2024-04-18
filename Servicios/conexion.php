<?php
// Clase que permite establecer la conexion a la base de datos MYSQL
class Conexion
{

    private $servidor;
    private $usuario;
    private $contrasena;
    private $baseDatos;
    public $conexion;

    public function __construct()
    {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->contrasena = "";
        $this->baseDatos = "bdproyecto";
    }

    public function conectar()
    {
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
        $this->conexion->set_charset("utf8");
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}

?>