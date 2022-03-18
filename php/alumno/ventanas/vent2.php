<?php
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../../index.html");
        return;
    }
    if($_SESSION['admin']!="ALUMNO"){
        header("Location:../../../index.html");
        return;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ventilación de sesi&oacute;n</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            extract($_POST);  //curso, seccion, aula, horario, fecha

    ?>
        <div class="row" style="background-color: rgb(187, 3, 3); height: 50px; margin-top: 0px">
            <div class="col-2"><button onclick="history.go(-3);" style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Atr&aacute;s </button></div>
            <div class="col-10"><h3 class="h3 text-center" style="font-family: 'Lucida Console'; color: white; margin-top: auto; font-size: 40px;">Ventilaci&oacute;n</h3> </div>
        </div>

        

            <div class="row" style="background-color: lightgray;">
                
                <div class="col-4" style="margin-left: 10%;">
                    <div class="row" style="margin-left:50px;">
                        <div class="col-3"> <a><b>Curso:</b></a> </div>
                        <div class="col-8"> <a><?php echo $curso ?></a> </div>
                    </div>
                    <div class="row" style="margin-left:50px;">
                        <div class="col-3"> <a><b>Secci&oacute;n:</b></a> </div>
                        <div class="col-8"> <a><?php echo $seccion ?></a> </div>
                    </div>
                    <div class="row" style="margin-left:50px;">
                        <div class="col-3"> <a><b>Aula</b></a> </div>
                        <div class="col-8"> <a><?php echo $aula ?></a> </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row" style="margin-left:50px;">
                        <div class="col-2"> <a><b>Horario:</b></a> </div>
                        <div class="col-8"> <a><?php echo $hora_inicio. " a ". $hora_fin; ?></a> </div>
                    </div>
                    <div class="row" style="margin-left:50px;">
                        <div class="col-2"> <a><b>Fecha:</b></a> </div>
                        <div class="col-8"> <a><?php echo $fecha ?></a> </div>
                    </div>
                </div>
            </div>

        <div class="container" style="margin-top:10px;">
            <br>

            <?php
            // ----------------- Query para obtener datos de la grafica ---------------
            $sql = "SELECT CO2aula, CO2externo, aforo, hora FROM ventilacion WHERE idsesion = '$idsesion' ORDER BY hora ASC";
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr', 'root', '');
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ejecucion del query SQL desde PHP
            try{
                $con = $pdo -> prepare($sql);
                $con -> execute();

            }catch(Exception $ex){
                header('Location:../menudocente.html'); //te manda al index si hay un error
                return;
            }

            $CO2aula_arr = array();
            $CO2ext_arr = array();
            $aforo_arr = array();
            $hora_arr = array();

            $vent_estado = "Ventilación adecuada";
            $color_est = 'green';
            $once = False;
            $maxAforoObt = 0;

            while($row = $con->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                array_push($CO2aula_arr, $CO2aula);
                array_push($CO2ext_arr, $CO2externo);
                array_push($aforo_arr, $aforo);
                array_push($hora_arr, $hora);
                if((int)$CO2aula - (int)$CO2externo < 600 && $once==False){
                    $vent_estado = "Ventilación inadecuada";
                    $once = True;
                    $color_est = 'red';
                }
                if($maxAforoObt < $aforo){
                    $maxAforoObt = $aforo;
                }
            }
                echo "<a style='font-family: Candara; alignment: center; color: ".$color_est."; font-size: 20px;'><b>".$vent_estado . "</b></a>";
            
                // ------- MENSAJE DE ALERTA SI SUPERA EL AFORO ----------
                
                $sql2 = "SELECT aforo_covid AS aforoMAX 
                        FROM cursos c INNER JOIN programacion p ON c.id = p.id WHERE p.idsesion = '$idsesion'";

                try{
                    $con2 = $pdo -> prepare($sql2);
                    $con2 -> execute();

                }catch(Exception $ex){
                    header('Location:../menudocente.html'); //te manda al index si hay un error
                    return;
                }
                //$maxAforoObt = 20;
                while($row = $con2->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    if($maxAforoObt > $aforoMAX){
                        echo "<script language=javascript>alert('El numero de asistentes ha superado el aforo permitido.')</script>";
                    }
                }


            
            ?>
            <canvas id="grafica" height="30vh" width="70vw"></canvas>
            <script type="text/javascript">
            
            const CO2aula = <?php echo json_encode($CO2aula_arr) ?>;
            const CO2ext = <?php echo json_encode($CO2ext_arr) ?>;
            const aforo = <?php echo json_encode($aforo_arr) ?>;
            const horas = <?php echo json_encode($hora_arr); ?>;

            const CO2aulaData = {
                    label: "CO2 dentro del aula (ppm)",
                    data: CO2aula,
                    backgroundColor: 'rgba(237,78,136, 0.2)', // Color de fondo
                    borderColor: 'rgba(237,78,136, 1)', // Color del borde
                    borderWidth: 1 // Ancho del borde
                };
            const CO2extData = {
                label: "CO2 afuera del aula (ppm)",
                data: CO2ext,
                backgroundColor: 'rgba(122, 169, 150, 0.2)', // Color de fondo
                borderColor: 'rgba(93,82,247,1)', // Color del borde
                borderWidth: 1 // Ancho del borde
            };
            const aforoData = {
                label: "Aforo",
                data: aforo,
                backgroundColor: 'rgba(89, 55, 150, 0.2)', // Color de fondo
                borderColor: 'rgba(119,45,247,1)', // Color del borde
                borderWidth: 1 // Ancho del borde
            };

            const $grafica = document.querySelector("#grafica");
            new Chart($grafica, { //linea 72
                type: 'line', // Tipo de gráfica
                data: {
                    labels: horas, //horas
                    datasets: [
                        CO2aulaData,
                        CO2extData,
                        aforoData,
                    ],
                    pointRadius: 15,
                    pointHoverRadius: 15,   
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    }   ,
                    elements: {
                        point: {
                            radius: 1,
                        }
                    },
                    plugins: {
                        legend: {
                            title: {
                                display: true,
                                text: 'Ventilación de la sesión',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                },
            });
            </script>

    </div>
        <?php 
        } ?>
</body>
</html>