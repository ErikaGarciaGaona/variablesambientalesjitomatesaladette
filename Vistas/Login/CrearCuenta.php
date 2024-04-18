<?php

require "../../Servicios/servicioLogin.php";

if (isset($_SESSION["id"])) {
    header("Location: ../Inicio/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="../../css/estilos.css" type="text/css">
    <link rel="stylesheet" href="../../css/logincss.css" type="text/css">
    <link href="../../lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="vh-100">

    <main class="container-fliud d-flex justify-content-center align-items-center h-100">
        <div action="" class="contenedor-form p-5 border rounded">

            <h1 class="text-center">Crear cuenta</h1>

            <div class="cont-vertical mb-2">
                <label for="correo" class="">Correo</label>
                <input type="mail" class="form-control" id="correo" name="correo">
                <p class="text-danger m-0 p-0 msg-error" id="correor"></p>
            </div>

            <div class="cont-vertical mb-2">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
                <p class="text-danger m-0 p-0 msg-error" id="nombrer"></p>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 w-100 mb-3">
                <div class="cont-vertical w-100">
                    <label for="genero" class="form-label">Genero</label>
                    <select class="form-select" id="genero" aria-label="Default select example">
                        <option selected>Seleccionar</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <p class="text-danger m-0 p-0 msg-error" id="generor"></p>
                </div>

                <div class="cont-vertical w-100">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="number" maxlength="2" min="1" max="99" class="form-control" id="edad" name="edad">
                    <p class="text-danger m-0 p-0 msg-error" id="edadr"></p>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <div class="cont-vertical mb-2">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena">
                    <p class="text-danger m-0 p-0 msg-error" id="contrasenar"></p>
                </div>

                <div class="cont-vertical mb-2">
                    <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirmarContrasena" name="confirmarContrasena">
                    <p class="text-danger m-0 p-0 msg-error" id="contrasenavr"></p>
                </div>
            </div>

            <div class="cont-boton-crear mb-3">
                <button onclick="CrearCuenta()" class="btn w-100">Crear Cuenta</button>
            </div>

            <div class="text-center">
                <a href="../../index.php" class="text-decoration-none">¿Ya Tengo Cuenta?</a>
            </div>

        </div>

    </main>

</body>

</html>

<!-- Jquery -->
<script src="../../lib/jquery-3.6.4.js">
</script>
<!-- Bootstrap -->
<script src="../../lib/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script>
    function CrearCuenta() {
        var correo = document.getElementById("correo").value.trim();
        var nombre = document.getElementById("nombre").value.trim();
        var genero = document.getElementById("genero");
        var edad = document.getElementById("edad").value.trim();
        var contrasena = document.getElementById("contrasena").value.trim();
        var confirmarContrasena = document.getElementById("confirmarContrasena").value.trim();

        if (!ValidarCamposRequeridos(correo, nombre, contrasena, confirmarContrasena, genero.value, edad)) {
            console.log("error")
            return;
        } else {
            console.log("sin error")
            var generoVal = genero.value;
            $.ajax({
                url: '../../Controlador/ControladorCrearCuenta.php',
                type: 'POST',
                data: {
                    correo: correo,
                    nombre: nombre,
                    contrasena: contrasena,
                    genero: generoVal,
                    edad: edad,
                    metodo: "CrearCuenta"
                },
                success: function(data) {
                    if (data === "true") {
                        alert("Ya existe una cuenta registrada con ese correo");
                    } else {
                        alert("Cuenta Creada exitosamente");
                        LimpiarFormulario()
                    }
                },
                cache: false
            })
        }


    }

    function ValidarCamposRequeridos(correo, nombre, contrasena, confirmarContrasena, genero, edad) {
        var resultado = true;

        var correor = document.getElementById("correor");
        var nombrer = document.getElementById("nombrer");
        var contrasenar = document.getElementById("contrasenar");
        var contrasenavr = document.getElementById("contrasenavr");

        if (correo.trim() === "") {
            correor.innerHTML = "Campo Requerido Correo"
            resultado = false;
        } else {
            correor.innerHTML = ""
        }

        if (nombre.trim() === "") {
            nombrer.innerHTML = "Campo Requerido Nombre"
            resultado = false;
        } else {
            nombrer.innerHTML = ""
        }

        if (genero.trim() === "Seleccionar") {
            generor.innerHTML = "Campo Requerido Genero"
            resultado = false;
        } else {
            generor.innerHTML = ""
        }

        if (edad.trim() === "") {
            edadr.innerHTML = "Campo Requerido Edad"
            resultado = false;
        } else {
            edadr.innerHTML = ""
        }

        if (contrasena.trim() === "") {
            contrasenar.innerHTML = "Campo Requerido Contraseña"
            resultado = false;
        } else {
            contrasenar.innerHTML = ""
        }

        if (confirmarContrasena.trim() === "") {
            contrasenavr.innerHTML = "Campo Requerido Confirmar Contraseña"
            resultado = false;
        } else {
            if (contrasena != confirmarContrasena) {
                contrasenavr.innerHTML = "La Contraseña No Conincide"
                resultado = false;
            } else {
                contrasenavr.innerHTML = ""
            }
        }

        return resultado;
    }

    function LimpiarFormulario() {
        var correo = document.getElementById("correo");
        var nombre = document.getElementById("nombre");
        var contrasena = document.getElementById("contrasena");
        var confirmarContrasena = document.getElementById("confirmarContrasena");

        correo.value = "";
        nombre.value = "";
        contrasena.value = "";
        confirmarContrasena.value = "";

        window.location.href = "../../index.php";
    }
</script>