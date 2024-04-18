<!DOCTYPE html>
<?php

require '../../Servicios/servicioPrincipal.php';

if (isset($_SESSION["id"])) {
    $idCuenta = $_SESSION["id"];

    $servicio = new ServicioPrincipal();

    $datos = $servicio->ObtenerUsuarioDatos($idCuenta);

    $configuraciones = $servicio->ObtenerConfiguraciones();

    // if ($datos["rol"] == "Administrador" || $datos["rol"] == "Laboratorista") {
    $plantas = $servicio->ObtenerPlantas();
    $ultimaFila = count($plantas) + 1;
    // }
} else {
    header("Location: ../../index.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <link href="../../lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex flex-column flex-lg-row">
            <div class="d-flex align-items-center gap-3">
                <a href="index.php">
                    <img src="../../img/LogoSaladette.png" alt="logo" class="logoP">
                </a>
                <a class="navbar-brand" href="index.php">Inicio</a>
            </div>

            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                <?php if (isset($datos['rol']) && $_SESSION['rol'] == "Administrador") {
                    echo '<a class="navbar-brand" href="GestionesCuentas.php">Gestionar Cuentas</a>';
                } ?>
                <a class="navbar-brand" href="perfil.php">Perfil</a>
                <a class="nav-link text-danger" href="../../Controlador/CerrarSession.php">Cerrer sessión</a>
            </div>
        </div>
    </nav>

    <main class="container-fluid">

        <div class="row">
            <!-- Perfil -->
            <div class="col-12 col-lg-6">
                <div class="container-fliud h-100">
                    <div class="row h-100">
                        <!-- FOTO PERFIL -->
                        <div class="col-12 col-lg-4 panel-perfil-imagen">
                            <div class="d-flex flex-column align-items-center mt-5">

                                <?php
                                if ($datos["genero"] == "Masculino") {
                                ?>
                                    <img src="../../img/hombre.png" class="img-perfil">
                                <?php } else { ?>
                                    <img src="../../img/mujer.png" class="img-perfil">
                                <?php } ?>


                                <div class="text-center text-white mt-2">
                                    <p class="fw-bold nombre"> <?php echo $datos["nombre"] ?> </p>
                                    <p class="rol"> <?php echo $datos["rol"] ?> </p>
                                </div>
                            </div>
                        </div>

                        <!-- INFORMACION -->
                        <div class="col-12 col-lg-8 panel-perfil-datos">
                            <div class="ms-3 mt-5">
                                <h3>información</h3>
                                <hr style="height: 3px;background-color:#B6B5BB;">
                                <div class="d-flex flex-column justify-content-center">
                                    <!-- EMAIL-TELEFONO -->
                                    <div class="d-flex align-items-center">
                                        <div class="text-start w-50">
                                            <h5>Email</h5>
                                            <p class="correo"><?php echo $datos["correo"] ?></p>
                                        </div>

                                        <div class="text-start w-50">
                                            <h5>Telefono</h5>
                                            <p class="telefono">1234567890</p>
                                        </div>
                                    </div>

                                    <!-- GENERO-EDAD -->
                                    <div class="d-flex align-items-center">
                                        <div class="text-start w-50">
                                            <h5>Genero</h5>
                                            <p class="genero"><?php echo $datos["genero"] ?></p>
                                        </div>

                                        <div class="text-start w-50">
                                            <h5>Edad</h5>
                                            <p class="edad"><?php echo $datos["edad"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CREAR FILA PLANTA -->
                            <?php if ($datos["rol"] == "Encargado" || $datos["rol"] == "Laboratorista") { ?>
                                <div class="ms-3 mt-5">
                                    <h3>Crear Nueva Fila</h3>
                                    <hr style="height: 3px;background-color:#B6B5BB;">

                                    <div class="card-crear-configuracion text-center gap-1 d-flex flex-column justify-content-center">
                                        <p class="card-titulo w-100 text-start ms-2">ID-F<?php echo $ultimaFila ?></p>
                                        <img src="../../img/tomates.png" class="card-configuracion-img">
                                        <div class="p-3">
                                            <input type="numeric" id="numero" class="form-control mb-2" placeholder="Numero Plantas">
                                            <input type="date" class="form-control" id="fechaSiembra" placeholder="yyyy-mm-dd">
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-50 mt-2" onclick="CrearPlanta()">Crear Fila</button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gestiones -->
            <div class="col-12 col-lg-6">
                <div class="panel-configuraciones mt-5">
                    <h3>Configuraciónes</h3>
                    <hr style="height: 3px;background-color:#B6B5BB;">
                    <!-- PLANTAS -->
                    <?php if ($datos["rol"] == "Administrador" || $datos["rol"] == "Laboratorista" || $datos["rol"] == "Auxiliar" || $datos["rol"] == "Encargado" || $datos["rol"] == "Coordinador de Carrera") { ?>
                        <div class="panel-card d-flex flex-wrap gap-2 justify-content-center">
                            <?php foreach ($plantas as $planta) { ?>
                                <div class="card-configuracion">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <p class="m-0 p-0 ms-2 mt-2 fw-bold">ID-F<?php echo $planta["idPlanta"] ?></p>
                                        <?php if ($datos["rol"] == "Laboratorista" || $datos["rol"] == "Encargado") { ?>
                                            <img class="me-2 mt-2" src="../../img/pala.png" style="width: 25px;object-fit:contain;" onclick="EliminarPlanta( <?php echo $planta['idPlanta']; ?> )">
                                        <?php } ?>
                                    </div>
                                    <img src="../../img/tomates.png" class="card-configuracion-img">
                                    <div class="d-flex flex-column card-configuracion-parrafo">
                                        <p>Numero de plantas: <?php echo $planta["totalPlantas"] ?></p>
                                        <p>Fecha de Siembre: <?php echo $planta["fechaSiembre"] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- TEM-HUMEDAD -->
                    <?php }
                    if ($datos["rol"] == "Administrador" || $datos["rol"] == "Laboratorista" || $datos["rol"] == "Auxiliar" || $datos["rol"] == "Encargado" || $datos["rol"] == "Coordinador de Carrera") { ?>

                        <div class="d-flex flex-column ms-3 m-5">

                            <h3>Rango de Variables Ambientales</h3>
                            <hr style="height: 3px;background-color:#B6B5BB;">

                            <div class="panel-card d-flex flex-column flex-lg-row flex-lg-wrap gap-2 justify-content-center align-items-center">
                                <div class="card-configuracion-parametros text-center mb-5 mb-lg-0">
                                    <p class="card-titulo mt-3">Temperatura</p>
                                    <img src="../../img/agua-tibia.png">
                                    <div class="d-flex align-items-center gap-2 mt-1 w-100">
                                        <input type="number" class="form-control" placeholder="°C" id="temperatura" value=<?php echo $configuraciones["temperatura"] ?>>

                                        <?php if ($datos["rol"] == "Encargado" || $datos["rol"] == "Laboratorista") { ?>
                                            <button class="btn btn-success" onclick="ActualizarParametro('1')">Actualizar</button>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="card-configuracion-parametros text-center mb-5 mb-lg-0">
                                    <p class="card-titulo mt-3">Humedad Ambiental</p>
                                    <img src="../../img/humedad.png">
                                    <div class="d-flex align-items-center gap-2 mt-1 w-100">
                                        <input type="number" class="form-control" placeholder="%" id="humedadAmbiental" value=<?php echo $configuraciones["humedadAmbiental"] ?>>

                                        <?php if ($datos["rol"] == "Encargado" || $datos["rol"] == "Laboratorista") { ?>
                                            <button class="btn btn-success" onclick="ActualizarParametro('2')">Actualizar</button>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="card-configuracion-parametros text-center mb-5 mb-lg-0">
                                    <p class="card-titulo mt-3">Humedad del Suelo</p>
                                    <img src="../../img/analisis-de-suelos.png">
                                    <div class="d-flex align-items-center gap-2 mt-1 w-100">
                                        <input type="number" class="form-control" placeholder="%" id="humedadSuelo" value=<?php echo $configuraciones["humedadSuelo"] ?>>

                                        <?php if ($datos["rol"] == "Encargado" || $datos["rol"] == "Laboratorista") { ?>
                                            <button class="btn btn-success" onclick="ActualizarParametro('3')">Actualizar</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

</body>

</html>

<script src=" https://code.jquery.com/jquery-3.6.4.js">
</script>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script>
    function CrearPlanta() {
        var numeroPlantas = document.getElementById("numero");
        var fechaSiembra = document.getElementById("fechaSiembra");

        if (numeroPlantas.value.trim() === "") {
            return;
        }

        if (fechaSiembra.value.trim() === "") {
            return;
        }

        $.ajax({
            url: '../../Controlador/ControladorPrincipal.php',
            type: 'POST',
            data: {
                numero: numeroPlantas.value,
                fecha: fechaSiembra.value,
                metodo: "CrearPlanta"
            },
            success: function(data) {
                if (data === "true") {
                    alert("Proceso exitoso, se realizo correctamente la creacion de la fila.");
                    location.reload();
                } else {
                    alert("Ocurrio un error al crear una nueva fila de plantas.");
                }
            },
            cache: false
        })
    }

    function EliminarPlanta(idPlanta) {
        $.ajax({
            url: '../../Controlador/ControladorPrincipal.php',
            type: 'POST',
            data: {
                idPlanta: idPlanta,
                metodo: "EliminarPlanta"
            },
            success: function(data) {
                if (data === "true") {
                    alert("Proceso exitoso, Se elimino la fila seleccionada.");
                    location.reload();
                } else {
                    alert("Ocurrio un error al eliminar la fila seleccionada.");
                }
            },
            cache: false
        })
    }

    function ActualizarParametro(tipoParametro) {
        var valor = "";
        //temp
        if (tipoParametro === "1") {
            valor = document.getElementById("temperatura").value;
        }

        //humAmbiental
        if (tipoParametro === "2") {
            valor = document.getElementById("humedadAmbiental").value;
        }

        //humSuelo
        if (tipoParametro === "3") {
            valor = document.getElementById("humedadSuelo").value;
        }

        $.ajax({
            url: '../../Controlador/ControladorPrincipal.php',
            type: 'POST',
            data: {
                valor: valor,
                tipo: tipoParametro,
                metodo: "ActualizarParametro"
            },
            success: function(data) {
                if (data === "true") {
                    alert("Proceso exitoso, se realizo correctamente la actualización del parametro.");
                    location.reload();
                } else {
                    alert("Ocurrio un error al actualizar el parametro.");
                }
            },
            cache: false
        })
    }
</script>