<?php
//Arquivo encargado de llamar el servicio del lado de la vista
require '../Servicios/ServicioLogin.php';

$metodo = $_POST['metodo'];

if ($metodo == 'CrearCuenta') {
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];
    $edad = $_POST['edad'];
    $contrasena = $_POST['contrasena'];

    $servicio = new ServicioLogin();
    $consulta = $servicio->CrearCuenta($correo, $nombre, $contrasena, $genero, $edad);
}

if ($metodo == 'IniciarSession') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $servicio = new ServicioLogin();

    $consulta = $servicio->ExisteCuenta($correo, $contrasena);

    if ($consulta) {
        print "true";
    } else {
        print "false";
    }
}
