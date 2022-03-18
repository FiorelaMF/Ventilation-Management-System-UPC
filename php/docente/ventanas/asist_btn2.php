<?php
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../index.html");
        return;
    }
    if($_SESSION['admin']!="DOCENTE"){
        header("Location:../../index.html");
        return;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Asistencias</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            extract($_POST);  //fecha, curso, seccion, campus, idsesion 

    ?>
        <div class="row" style="background-color: rgb(187, 3, 3); height: 50px; margin-top: 0px">
            <div class="col-2"><button onclick="history.go(-3);" style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Atr&aacute;s </button></div>
            <div class="col-10"><h3 class="h3 text-center" style="font-family: 'Lucida Console'; color: white; margin-top: auto; font-size: 40px;">Asistencia del curso</h3> </div>
        </div>

            
            <div class="row" style="background-color: lightgray;">
                <div class="col-4" style="margin-left: 10%;">
                    <div class="row" style="margin-left:50px;">
                        <div class="col-3"> <a><b>Fecha:</b></a> </div>
                        <div class="col-8"> <a><?php echo $fecha ?></a> </div>
                    </div>
                    <div class="row" style="margin-left:50px;">
                        <div class="col-3"> <a><b>Curso:</b></a> </div>
                        <div class="col-8"> <a><?php echo $curso ?></a> </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="row" style="margin-left:50px;">
                        <div class="col-2"> <a><b>Secci&oacute;n:</b></a> </div>
                        <div class="col-8"> <a><?php echo $seccion ?></a> </div>
                    </div>
                    <div class="row" style="margin-left:50px;">
                        <div class="col-2"> <a><b>Campus:</b></a> </div>
                        <div class="col-8"> <a><?php echo $campus ?></a> </div>
                    </div>
                </div>
            </div>

            <br>
            <table class='table table-bordered text-center' style="width: 80%; margin-left: auto; margin-right: auto;">
            <thead>
                <th>C&oacute;digo</th>
                <th>Nombre Completo</th>
                <th>Hora de entrada</th>
                <th>Hora de salida</th>
                <th>Estado</th>
                <th>Temperatura</th>
            </thead>

            <tbody>
            <?php
            $sql = "SELECT a.codigo, CONCAT(p.apellidop, ' ', p.apellidom, ', ', p.nombre) AS nombreComp, 
                    a.hora_entrada, a.hora_salida, a.estado, a.temperatura 
                    FROM asistencia a INNER JOIN personal p ON a.codigo = p.codigo 
                    WHERE p.estado = 'ALUMNO' AND a.idsesion = '$idsesion' ORDER BY nombreComp ASC";
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
            // IMPRIMIMOS DATOS DE LA TABLA
            while($row = $con->fetch(PDO::FETCH_ASSOC)){
                extract($row);  
                echo "<tr>";
                echo "<td>".$codigo."</td>";
                echo "<td>".utf8_encode($nombreComp)."</td>";
                echo "<td>".$hora_entrada."</td>";
                echo "<td>".$hora_salida."</td>";
                echo "<td>".utf8_encode($estado)."</td>";
                echo "<td>".$temperatura."</td>";
                echo "</tr>";
            }

            ?>
            </tbody>
        <?php
        } ?>
</body>
</html>