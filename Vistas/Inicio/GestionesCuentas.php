<!DOCTYPE html>
<?php

require '../../Servicios/servicioPrincipal.php';

if (isset($_SESSION["id"]) && $_SESSION['rol'] == "Administrador") {
    $idCuenta = $_SESSION["id"];

    $servicio = new ServicioPrincipal();

    $datos = $servicio->ObtenerUsuarioDatos($idCuenta);
    $usuarios = $servicio->ObtenerTodosLosUsuarios();
} else {
    header("Location: ../Inicio/index.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestiones</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <link href="../../lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="vh-100">

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

    <main class="container-fluid h-100">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-2">Gestionar Cuentas</h1>
            </div>

            <div class="col-12">
                <div class="table-responsives">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Actualizar</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $numeral = 0;


                            foreach ($usuarios as $usuario) {
                                $numeral++;
                            ?>
                                <?php if ($datos['idCuenta'] != $usuario['idCuenta']) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $numeral ?></th>
                                        <td><?php echo $usuario["nombre"] ?></td>
                                        <td><?php echo $usuario["correo"] ?></td>
                                        <td>
                                            <select class="form-select" id="cmbRol<?php echo $usuario['idCuenta']; ?>" aria-label="Default select example">
                                                <option selected>Seleccionar</option>
                                                <option value="Administrador" <?php if ($usuario["rol"] == "Administrador") echo 'selected = "selected"'; ?>>Administrador</option>
                                                <option value="Coordinador de Carrera" <?php if ($usuario["rol"] == "Coordinador de Carrera") echo 'selected = "selected"'; ?>>Coordinador de Carrera</option>
                                                <option value="Laboratorista" <?php if ($usuario["rol"] == "Laboratorista") echo 'selected = "selected"'; ?>>Laboratorista</option>
                                                <option value="Auxiliar" <?php if ($usuario["rol"] == "Auxiliar") echo 'selected = "selected"'; ?>>Auxiliar</option>
                                                <option value="Encargado" <?php if ($usuario["rol"] == "Encargado") echo 'selected = "selected"'; ?>>Encargado</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="EditarUsuario('<?php echo $usuario['idCuenta']; ?>')">Actualizar</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="EliminarUsuario(<?php echo $usuario['idCuenta']; ?>)">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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
    function EditarUsuario(idCuentaValor) {
        const rolValor = document.getElementById("cmbRol" + idCuentaValor);

        if (rolValor.value != "Seleccionar") {
            $.ajax({
                url: '../../Controlador/ControladorPrincipal.php',
                type: 'POST',
                data: {
                    idCuenta: idCuentaValor,
                    rol: rolValor.value,
                    metodo: "Actualizar"
                },
                success: function(data) {
                    if (data === "true") {
                        alert("Proceso exitoso, se realizo correctamente la actualizacion de la cuenta");
                        location.reload();
                    } else {
                        alert("Ocurrio un error al actulizar la cuenta seleccionada");
                    }
                },
                cache: false
            })
        } else {
            rolValor.classList.add("border");
            rolValor.classList.add("border-danger");
            rolValor.classList.add("border-2");
            alert("Seleccione un rol valido para el usuario");
        }
    }

    function EliminarUsuario(idCuenta) {
        $.ajax({
            url: '../../Controlador/ControladorPrincipal.php',
            type: 'POST',
            data: {
                idCuenta: idCuenta,
                metodo: "Eliminar"
            },
            success: function(data) {
                if (data === "true") {
                    alert("Proceso exitoso, se elimino la cuenta seleccionada");
                    location.reload();
                } else {
                    alert("Ocurrio un error al eliminar la cuenta");
                }
            },
            cache: false
        })
    }
</script>