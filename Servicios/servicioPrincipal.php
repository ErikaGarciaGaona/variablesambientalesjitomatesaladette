<?php
session_start();
// Clase que permite obtener la conexion y ejecutar consultas
class ServicioPrincipal
{
    private $conexion;

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }

    public function ObtenerUsuarioDatos($idCuenta)
    {
        $sql = "SELECT idCuenta,nombre,correo,rol,genero,edad FROM cuentas where idCuenta = $idCuenta";

        $resultado = $this->conexion->conexion->query($sql);

        $datos = $resultado->fetch_assoc();

        return $datos;
    }

    public function ObtenerPlantas()
    {
        $sql = "SELECT * FROM plantas";

        $plantas = array();

        $resultado = $this->conexion->conexion->query($sql);

        while ($consulta = mysqli_fetch_array($resultado)) {
            $plantas[] = $consulta;
        }

        return $plantas;
    }

    public function ObtenerTodosLosUsuarios()
    {
        $usuarios = array();

        $sql  = "SELECT idCuenta,nombre,correo,rol FROM cuentas";

        $resultado = $this->conexion->conexion->query($sql);

        while ($consulta = mysqli_fetch_array($resultado)) {
            $usuarios[] = $consulta;
        }

        return $usuarios;
    }

    public function ActualizarCuenta($idCuenta, $rol)
    {
        //Insertar cuenta
        $sql = "UPDATE cuentas SET rol = '$rol' WHERE idCuenta = '$idCuenta'";

        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }

        $this->conexion->cerrarConexion();
    }

    public function EliminarCuenta($idCuenta)
    {
        //Insertar cuenta
        $sql = "DELETE FROM cuentas WHERE idCuenta = '$idCuenta'";

        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }

        $this->conexion->cerrarConexion();
    }

    public function CrearPlanta($numero, $fecha)
    {
        //Insertar cuenta
        $sql = "INSERT INTO plantas VALUES (0,'$numero','$fecha')";

        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }

        $this->conexion->cerrarConexion();
    }

    public function EliminarPlanta($idPlanta)
    {
        //Insertar cuenta
        $sql = "DELETE FROM plantas WHERE idPlanta = '$idPlanta'";

        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }

        $this->conexion->cerrarConexion();
    }

    public function ActualizarParametro($tipo, $valor)
    {
        if ($tipo == "1") {
            $sql = "UPDATE configuraciones SET temperatura = '$valor' WHERE idConfiguracion = '1'";
        }

        if ($tipo == "2") {
            $sql = "UPDATE configuraciones SET humedadAmbiental = '$valor' WHERE idConfiguracion = '1'";
        }

        if ($tipo == "3") {
            $sql = "UPDATE configuraciones SET humedadSuelo = '$valor' WHERE idConfiguracion = '1'";
        }

        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }

        $this->conexion->cerrarConexion();
    }

    public function ObtenerConfiguraciones()
    {
        $sql = "SELECT * FROM configuraciones";

        $resultado = $this->conexion->conexion->query($sql);

        $datos = $resultado->fetch_assoc();

        return $datos;
    }

    public function ObtenerDatosTemperatura()
    {
        // $sql = "DELETE FROM temperatura";

        $sql = "SELECT valor FROM temperatura";

        $datos = array();

        $resultado = $this->conexion->conexion->query($sql);

        while ($consulta = mysqli_fetch_array($resultado)) {
            $datos[] = $consulta;
        }

        return $datos;
    }

    public function ObtenerDatosHumedadSuelo()
    {
        // $sql = "DELETE FROM temperatura";

        $sql = "SELECT valor FROM humedadSuelo";

        $datos = array();

        $resultado = $this->conexion->conexion->query($sql);

        while ($consulta = mysqli_fetch_array($resultado)) {
            $datos[] = $consulta;
        }

        return $datos;
    }

    public function ObtenerDatosHumedadAmbiental()
    {
        // $sql = "DELETE FROM temperatura";

        $sql = "SELECT valor FROM humedadAmbiental";

        $datos = array();

        $resultado = $this->conexion->conexion->query($sql);

        while ($consulta = mysqli_fetch_array($resultado)) {
            $datos[] = $consulta;
        }

        return $datos;
    }

    public function MandarDatosArchivo($temp, $humSue)
    {
        //Primero delete de los array que tengan datos
        if (is_array($temp) && count($temp) > 0) {
            //Insertar cuenta
            $sql = "DELETE FROM temperatura";

            $this->conexion->conexion->query($sql);

            for ($i = 0; $i < count($temp); $i++) {
                $sql = "INSERT INTO temperatura values (0,$temp[$i])";

                $this->conexion->conexion->query($sql);
            }
        }

        if (is_array($humSue) && count($humSue) > 0) {
            //Insertar cuenta
            $sql = "DELETE FROM humedadSuelo";

            $this->conexion->conexion->query($sql);

            for ($i = 0; $i < count($humSue); $i++) {
                $sql = "INSERT INTO humedadsuelo values (0,$humSue[$i])";

                $this->conexion->conexion->query($sql);
            }
        }

        $this->conexion->cerrarConexion();

        return true;
    }
}//Fin clase
