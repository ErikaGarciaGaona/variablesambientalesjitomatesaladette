<?php
//Arquivo encargado de llamar el servicio del lado de la vista
require '../Servicios/ServicioPrincipal.php';

$metodo = $_POST['metodo'];

if ($metodo == 'Actualizar') {
    $idCuenta = $_POST['idCuenta'];
    $rol = $_POST['rol'];

    $servicio = new ServicioPrincipal();

    $consulta = $servicio->ActualizarCuenta($idCuenta, $rol);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}

if ($metodo == 'Eliminar') {
    $idCuenta = $_POST['idCuenta'];

    $servicio = new ServicioPrincipal();

    $consulta = $servicio->EliminarCuenta($idCuenta);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}

if ($metodo == 'CrearPlanta') {
    $numero = $_POST['numero'];
    $fecha = $_POST['fecha'];

    $servicio = new ServicioPrincipal();

    $consulta = $servicio->CrearPlanta($numero, $fecha);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}

if ($metodo == 'EliminarPlanta') {
    $idPlanta = $_POST['idPlanta'];

    $servicio = new ServicioPrincipal();

    $consulta = $servicio->EliminarPlanta($idPlanta);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}

if ($metodo == 'ActualizarParametro') {
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];

    $servicio = new ServicioPrincipal();

    $consulta = $servicio->ActualizarParametro($tipo, $valor);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}

if ($metodo == 'CargarDatosGraficos') {
    $opcion = $_POST['opcion'];

    $servicio = new ServicioPrincipal();
    $datos = array();

    if ($opcion == "1") {
        $datos = $servicio->ObtenerDatosTemperatura();
    }

    if ($opcion == "2") {
        $datos = $servicio->ObtenerDatosHumedadAmbiental();
    }

    if ($opcion == "3") {
        $datos = $servicio->ObtenerDatosHumedadSuelo();
    }

    echo json_encode($datos);
}

if ($metodo == 'MandarDatosArchivo') {
    $temp = $_POST['temperatura'];
    $humAmb = $_POST['humedadAmbiental'];
    $humSue = $_POST['humedadSuelo'];

    $servicio = new ServicioPrincipal();

    $resultado = $servicio->MandarDatosArchivo($temp, $humSue);

    if ($resultado) {
        print "false";
    } else {
        print "true";
    }
}
