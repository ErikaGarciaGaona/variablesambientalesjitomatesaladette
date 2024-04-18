<?php
// Clase que permite obtener la conexion y ejecutar consultas
session_start();

class ServicioLogin
{
    private $conexion;

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }

    public function CrearCuenta($correo, $nombre, $contrasena, $genero, $edad)
    {
        // Validar cuentas existentes
        $ob = new ServicioLogin();
        if ($ob->ExisteCorreoRegistrado($correo)) {
            print "true";
            return;
        }

        //Insertar cuenta
        $sql = "INSERT INTO cuentas (correo,nombre,contrasena,rol,genero,edad) VALUES ('$correo','$nombre','$contrasena','Administrador','$genero','$edad')";

        if ($this->conexion->conexion->query($sql)) {
            print "false";
        } else {
            print "true";
        }

        $this->conexion->cerrarConexion();
    }

    function ExisteCorreoRegistrado($correo)
    {

        $sql = "SELECT * FROM cuentas WHERE correo = '$correo'";

        $arreglo = array();

        if ($consulta = $this->conexion->conexion->query($sql)) {

            while ($consultaa = mysqli_fetch_array($consulta)) {
                $arreglo[] = $consultaa;
            }
        }

        if (count($arreglo) > 0) {
            return true;
        }
    }

    public function ExisteCuenta($correo, $contrasena)
    {
        $sql = "SELECT * FROM cuentas WHERE correo = '$correo' AND contrasena = '$contrasena'";
        $idvalor = "";
        $rol = "";
        if ($consulta = $this->conexion->conexion->query($sql)) {

            while ($consultaa = mysqli_fetch_array($consulta)) {
                $idvalor = $consultaa['idCuenta'];
                $rol = $consultaa['rol'];
                $arreglo[] = $consultaa;
            }
        }

        if (count($arreglo) > 0) {
            $_SESSION["id"] = $idvalor;
            $_SESSION["rol"] = $rol;
            return true;
        } else {
            return false;
        }
    }
}
