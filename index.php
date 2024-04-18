<?php

require "./Servicios/servicioLogin.php";

if (isset($_SESSION["id"])) {
    header("Location: ./Vistas/Inicio/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Session</title>
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/logincss.css">
    <link href="./lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="vh-100">

    <main class="container-fliud d-flex flex-column justify-content-center align-items-center h-100">

        <div action="" class="contenedor-form d-flex flex-column justify-content-center align-items-center p-5 border rounded gap-3">
            <p class="titulo">Iniciar Session</p>

            <div class="d-flex flex-column">
                <label for="correo" class="mb-3">Correo Electronico</label>
                <div class="contenedor-input">
                    <span class="icono">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                    </span>

                    <input type="email" id="correo" placeholder="Ingrese su Correo Electronico" class="form-control">
                </div>
            </div>

            <div class="d-flex flex-column">
                <label for="correo" class="mb-3">Contraseña</label>
                <div class="contenedor-input">
                    <span class="icono">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>

                    <input type="password" id="contrasena" placeholder="Ingrese su Contraseña" class="form-control">
                </div>
            </div>

            <div class="w-100">
                <button onclick="IniciarSession()" class="btn w-100">Iniciar sesion</button>
            </div>

            <div class="text-center">
                <p class="text-secondary">¿No tienes Cuenta? <a href="./Vistas/Login/CrearCuenta.php" class="text-decoration-none">Crear Cuenta</a> </p>
            </div>
        </div>
    </main>
</body>

</html>

<!-- Jquery -->
<script src="./lib/jquery-3.6.4.js">
</script>
<!-- Bootstrap -->
<script src="./lib/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script>
    function IniciarSession() {
        var correo = document.getElementById("correo").value.trim();
        var contrasena = document.getElementById("contrasena").value.trim();
        var existe = false;

        $.ajax({
            url: './Controlador/ControladorCrearCuenta.php',
            type: 'POST',
            data: {
                correo: correo,
                contrasena: contrasena,
                metodo: "IniciarSession"
            },
            success: function(data) {
                if (data === "true") {
                    window.location.href = "./Vistas/Inicio/index.php"
                } else {
                    alert("Correo o Contraseña incorrectos")
                }
            }
        })
    }
</script>