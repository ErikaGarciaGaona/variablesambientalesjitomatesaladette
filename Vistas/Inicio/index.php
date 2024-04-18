<?php

require '../../Servicios/servicioPrincipal.php';

if (isset($_SESSION["id"])) {
    $idCuenta = $_SESSION["id"];

    $servicio = new ServicioPrincipal();

    $datos = $servicio->ObtenerUsuarioDatos($idCuenta);
} else {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <link href="../../lib/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../../lib/Chart.css" integrity="sha512-SUJFImtiT87gVCOXl3aGC00zfDl6ggYAw5+oheJvRJ8KBXZrr/TMISSdVJ5bBarbQDRC2pR5Kto3xTR0kpZInA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="vh-100" onload="CargarDatosGrafica()">

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
            <div class="col-12">
                <div class="d-flex flex-column">
                    <h1 class="mt-2">Bienvenido <span class="text-success"><?php echo $datos["nombre"] ?></span></h1>

                    <div class="d-flex gap-2 mt-2">
                        <input class="form-control form-control-sm" id="txtArchivo" type="file" style="width: 500px;">
                    </div>
                </div>
            </div>

            <!-- GRAFICO -->
            <div class="col-12 d-flex justify-content-center">
                <div class="mt-3" style="width: 100%;">
                    <canvas id="graficaParametros"></canvas>
                </div>
            </div>

            <!-- Estadistica -->
            <div class="col-12 d-flex flex-column flex-lg-row gap-5 justify-content-center align-items-center mt-3 mb-3">
                <div class="d-flex justify-content-center align-items-center estadistica-border border-2 rounded p-2 gap-1" style="width: auto;">
                    <p class="m-0 p-0">Maxima</p>
                    <p class="m-0 p-0" id="maxima">-</p>
                </div>

                <div class="d-flex justify-content-center align-items-center estadistica-border border-2 rounded p-2 gap-1" style="width: auto;">
                    <p class="m-0 p-0">Minima</p>
                    <p class="m-0 p-0" id="minima">-</p>
                </div>

                <div class="d-flex justify-content-center align-items-center estadistica-border border-2 rounded p-2 gap-1" style="width: auto;">
                    <p class="m-0 p-0">Desviacion Estandar</p>
                    <p class="m-0 p-0" id="desvEstandar">-</p>
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
<!-- ChartsJs -->
<script src="../../lib/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../../lib/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Excel -->
<script src="../../lib/read-excel-file.min.js"></script>

<script>
    function CargarDatosGrafica() {

        var labels = [];
        var totales = [];
        var valoresTemperatura = [];
        var valoresAmbiental = [];
        var valoresSuelo = [];

        for (let index = 1; index < 4; index++) {
            $.ajax({
                url: '../../Controlador/ControladorPrincipal.php',
                type: 'POST',
                data: {
                    metodo: "CargarDatosGraficos",
                    opcion: index
                }
            }).done(function(resp) {

                var data = JSON.parse(resp);

                //Validaciones para obtener las longitudes de cada array de los parametros
                //1-temperatura
                //2-humedad ambiental
                //3-humedad suelo
                if (index === 1) {
                    totales.push(data.length);
                }

                if (index === 2) {
                    totales.push(data.length);
                }

                if (index === 3) {
                    totales.push(data.length);
                }

                //Iteracion y valudacion para mandar los valores de los arrays a los que corresponden
                for (let i = 0; i < data.length; i++) {
                    if (index === 1) {
                        valoresTemperatura.push(data[i][0]);
                    }

                    if (index === 2) {
                        valoresAmbiental.push(data[i][0]);
                    }

                    if (index === 3) {
                        valoresSuelo.push(data[i][0]);
                    }
                }

                //Cuando ya obtuvo todos los arrays de los parametros va a generar la grafica
                if (index === 3) {
                    var valorMenor = Math.min(...totales);

                    //Eliminar datos repetidos
                    var totalesSinRepetir = EliminarDatosRepetidosArray(totales);

                    //Saca diferencia de totales
                    var diferenciaTotal = ObtenerDiferenciaDeDatos(totalesSinRepetir, valorMenor);

                    //Asigna los labels horizontales para la grafica
                    labels = GenerarLabels(diferenciaTotal, valorMenor);

                    //Creacion de grafica
                    CrearGrafica(valoresTemperatura, valoresAmbiental, valoresSuelo, labels);

                    var totalDatos = valoresTemperatura.concat(valoresAmbiental);

                    ObtenerMaxima(totalDatos);
                    ObtenerMinima(totalDatos);
                    DesviacionEstandar(totalDatos);
                }
            }) //Fin done
        }
    } //Fin funcion

    function EliminarDatosRepetidosArray(datos) {
        //Eliminar datos repetidos
        return datos.filter((item,
            index) => datos.indexOf(item) === index);
    }

    function ObtenerDiferenciaDeDatos(datos, menorValor) {
        var total = 0;
        for (let index = 0; index < datos.length; index++) {
            if (datos[index] != menorValor) {
                total += datos[index] - menorValor;
            }
        }
        return total;
    }

    function GenerarLabels(diferenciaTotal, valorMenor) {
        var labels = [];

        for (let index = 0; index < (diferenciaTotal + valorMenor); index++) {
            labels.push(index + 1);
        }

        return labels;
    }

    function CrearGrafica(valoresTemperatura, valoresAmbiental, valoresSuelo, labels) {
        new Chart(
            document.getElementById('graficaParametros'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Temperatura °C',
                            data: valoresTemperatura,
                            borderColor: ['rgb(220, 53, 69)'],
                            backgroundColor: ['rgba(220, 53, 69,0.0)']
                        }, {
                            label: 'Humedad Ambiental %',
                            data: valoresAmbiental,
                            borderColor: ['rgb(13, 110, 253)'],
                            backgroundColor: ['rgba(13, 110, 253,0.0)']
                        },
                        {
                            label: 'Humedad Suelo %',
                            data: valoresSuelo,
                            borderColor: ['rgb(25, 135, 84)'],
                            backgroundColor: ['rgba(25, 135, 84,0.0)']
                        }
                    ]
                }
            }
        ); //fin Chart
    }

    function ObtenerMaxima(datos) {
        var label = document.getElementById("maxima");
        var valor = Math.max(...datos);
        label.innerHTML = valor;
    }

    function ObtenerMinima(datos) {
        var label = document.getElementById("minima");
        var valor = Math.min(...datos);
        label.innerHTML = valor;
    }

    function DesviacionEstandar(arr) {
        var label = document.getElementById("desvEstandar");

        var totalesSinDeciamles = []

        for (let index = 0; index < arr.length; index++) {
            totalesSinDeciamles.push(Math.trunc(arr[index]));
        }

        arr = totalesSinDeciamles;

        // Creating the mean with Array.reduce
        let mean = arr.reduce((acc, curr) => {
            return acc + curr
        }, 0) / arr.length;

        // Assigning (value - mean) ^ 2 to every array item
        arr = arr.map((k) => {
            return (k - mean) ** 2
        })

        // Calculating the sum of updated array
        let sum = arr.reduce((acc, curr) => acc + curr, 0);

        // Calculating the variance
        let variance = sum / arr.length

        // Returning the Standered deviation
        var resultado = Math.sqrt(sum / arr.length)

        label.innerHTML = resultado;
    }

    //LECTURA DE EXCEL
    const inputExcel = document.getElementById("txtArchivo");
    var temperatura = [];
    var humedadAmbiental = [];
    var humedadSuelo = [];

    inputExcel.addEventListener('change', async function() {
        //Funcion de cnd
        const contenido = await readXlsxFile(inputExcel.files[0]);

        for (let i = 3; i < contenido.length; i++) {
            humedadSuelo.push(contenido[i][0]);
            temperatura.push(contenido[i][1]);
            console.log(contenido[i][0] + " " + contenido[i][1]);
        }

        //Metodo ajax para mandar los datos obtenidos
        $.ajax({
            url: '../../Controlador/ControladorPrincipal.php',
            type: 'POST',
            data: {
                temperatura: temperatura,
                humedadAmbiental: humedadAmbiental,
                humedadSuelo: humedadSuelo,
                metodo: "MandarDatosArchivo"
            },
            success: function(data) {
                if (data === "true") {
                    alert("Ocurrio un error al cargar los datos.");
                } else {
                    alert("Proceso exitoso, se realizo correctamente la carga de los datos del archivo.");
                    location.reload();
                }
            },
            cache: false
        })
    })
</script>