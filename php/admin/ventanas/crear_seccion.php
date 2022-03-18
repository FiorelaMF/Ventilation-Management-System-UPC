<?php
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../index.html");
        return;
    }
    if($_SESSION['admin']!="ADMIN"){
        header("Location:../../index.html");
        return;
    }

    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes"> 

    <style>
        .btn-primary btn-lg{
            color: rgb(187, 3, 3);
            font-family: 'Trebuchet MS';
            border-color: darkred; 
            width: 70%;
        }

    </style>

    <script language="javascript">
            function reload(form){
                //var v1=document.getElementById('s1').value();
                var v1=form.campus4.options[form.campus4.options.selectedIndex].value;
                var v2=form.codcurso.options[form.codcurso.options.selectedIndex].value;
                self.location = 'crear_seccion.php?campus4='+v1;
            }
            function volver(){
                self.location='../menuadmin.php';
            }
    </script>

    <body>
    <button onclick='volver()' style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Volver al men&uacute; </button>
    <div class="container" id="crea_seccion_nueva" style="margin-top:10px;">
        
        <h2 class="h2 text-center">Crear secci&oacute;n nueva </h2>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col-8">
                    <select class="form-select" aria-label="Default select example" name="codcurso" style="width: 80%;">
                        <option selected>C&oacute;digo de curso</option>
                    <?php
                        $sql = "SELECT DISTINCT(codcurso), curso FROM cursos ORDER BY codcurso";
                            try{
                                $obj = $pdo -> prepare($sql);
                                $obj -> execute();
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar cursos.');"; 
                            }

                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='$codcurso'>".$codcurso." - " .utf8_encode($curso)."</option>";
                            } 
                    ?>
                    </select>
                </div>
                
            </div>
                        
            <br>
            <div class="row">
                <div class="col-1"  style="text-align: right;">
                    <label class="form-label"><b>Secci&oacute;n:</b></label>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="seccion"  style="width: 40%;"> 
                </div>
                <div class="col-6" style="text-align: left;">
                    <select class="form-select" aria-label="Default select example" name="campus4" id='s1' onChange='reload(this.form)' style="margin-left: auto; margin-right: auto; width: 50%;">
                        <option selected>Campus</option>
                        <option value="MO">MO</option>
                        <option value="SM">SM</option>
                        <option value="SI">SI</option>
                        <option value="VI">VI</option>
                    </select>
                </div>
                
                
            </div>

            <br>
            <div class="row">
                <div class="col-6"  style="text-align: left;">
                    <select class="form-select" aria-label="Default select example" name="aula" style="width:50%; text-align: left;">
                        <option selected>Aula</option>
                    <?php
                        if( isset($_GET['campus4'])){
                            $campus = $_GET['campus4'];
                            $sql = "SELECT DISTINCT(aula) FROM cursos WHERE campus=?";

                            $obj = $pdo -> prepare($sql);

                            $obj -> bindParam(1, $campus, PDO::PARAM_STR, 5);
                            $obj -> execute();
                            
                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='$aula'>".$aula."</option>";
                            } 
                        }
                    ?>
                    </select>
                </div>

                <div class="col-6">
                    <select class="form-select" aria-label="Default select example" name="dia" style="margin-left: auto; margin-right: auto; width:50%;">
                        <option selected>D&iacute;a</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Mi&eacute;rcoles">Mi&eacute;rcoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="S&aacute;bado">S&aacute;bado</option>
                        <option value="Domingo">Domingo</option>
                    </select>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-4">
                    <select class="form-select" aria-label="Default select example" name="hora_inicio" style="margin-left: auto; margin-right: auto;">
                        <option selected>Hora de inicio</option>
                        <?php
                        for($h=7; $h<22; $h++){
                            $hour = strval($h).":00";
                            echo "<option value='$hour'>".$hour."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-select" aria-label="Default select example" name="hora_fin" style="margin-left: auto; margin-right: auto;">
                        <option selected>Hora de fin</option>
                        <?php
                        for($h=9; $h<24; $h++){
                            $hour = strval($h).":00";
                            echo "<option value='$hour'>".$hour."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-select" aria-label="Default select example" name="tipo" style="margin-left: auto; margin-right: auto;">
                        <option selected>Tipo de sesi&oacute;n</option>
                        <option value="LB">LB</option>
                        <option value="PR">PR</option>
                        <option value="TE">TE</option>
                        <option value="TA">TA</option>
                    </select>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-6">
                    <select class="form-select" aria-label="Default select example" name="ciclo" style="margin-left: auto; margin-right: auto; width: 50%;">
                        <option selected>Ciclo</option>
                        <option value="2021-2">2021-2</option>
                        <option value="2022-0">2022-0</option>
                        <option value="2022-1">2022-1</option>
                    </select>
                </div>
                <div class="col-1" style="text-align: right;">
                    <label class="form-label"><b>Aforo COVID:</b></label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" name="aforo_covid" placeholder=10 style="width:50%;"> 
                </div>
            </div>
            
            <br>
            <div class="row" style="text-align: center;">
                <div class="col-4">
                    <button class="btn-primary btn-lg" type="submit" name="crear">CREAR</button>
                </div>
                <div class="col-4">
                    <button class="btn-primary btn-lg" type="submit" name="editar">EDITAR</button>
                </div>
                <div class="col-4">
                    <button class="btn-primary btn-lg" type="submit" name="buscar">BUSCAR</button>
                </div>
            </div>

        </form>

    </div>
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['codcurso']) && isset($_POST['seccion']) 
                && isset($_POST['aula']) ){
                $codcurso = $_POST['codcurso'];
                $seccion = $_POST['seccion'];       //$campus = $_POST['campus4'];
                $aula = $_POST['aula'];             $dia = $_POST['dia'];
                $hora_inicio = $_POST['hora_inicio']; $hora_fin = $_POST['hora_fin'];
                $tipo = $_POST['tipo'];
                $ciclo = $_POST['ciclo'];     
                
                

                    // -------------- BOTON  CREAR ------------------
                    if (isset($_POST['crear'])){

                        // verificar cruce de dia y hora respecto al aula
                        $sql = "SELECT seccion FROM cursos WHERE aula = '$aula' AND ciclo = '$ciclo' AND dia = '$dia' 
                                AND (hora_inicio >= TIME('$hora_inicio') OR hora_inicio + TIME('1:00') = TIME('$hora_inicio')) 
                                AND hora_fin <= TIME('$hora_fin')";
                        try{
                            $obj = $pdo -> prepare($sql);
                            $obj -> execute();
                            $row = $obj->fetch(PDO::FETCH_ASSOC);
                        } catch(Exception $ex){
                            echo "<script languaje=javascript> alert('Error al buscar carreras.');</script>"; 
                        }

                        if(empty($row)){ // si no hay cruce
                            // verificar que no exista otra seccion con el mismo nombre
                            $sql2 = "SELECT seccion FROM cursos WHERE seccion = '$seccion'";
                            try{
                                $obj = $pdo -> prepare($sql2);
                                $obj -> execute();
                                $row = $obj -> fetch(PDO::FETCH_ASSOC);
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar secciones.');</script>"; 
                            }
                            if(empty($row)){ //no hay secciones iguales
                                // verificar aforo
                                $sql3 = "SELECT aforo_covid FROM cursos WHERE aula = '$aula'";
                                $obj = $pdo -> prepare($sql3);
                                $obj -> execute();
                                $row = $obj -> fetch(PDO::FETCH_ASSOC);

                                if(!empty($row)){  // significa que el aula ya tiene aforo
                                    extract($row);
                                        $aforo = $row['aforo_covid'];
                                    
                                } else{
                                    $aforo = $_POST['aforo_covid'];
                                }

                                //conseguir nombre del curso
                                $sql4 = "SELECT curso FROM cursos WHERE codcurso = '$codcurso'";
                                $obj = $pdo -> prepare($sql4);
                                $obj -> execute();
                                while($row = $obj -> fetch(PDO::FETCH_ASSOC)){
                                    $curso = utf8_encode($row['curso']);   
                                }

                                 // si todo sale bien, ingresar nueva seccion
                                $sql5 = "INSERT INTO `cursos` (`id`, `codcurso`, `curso`, `seccion`, `campus`, `aula`, `dia`, `hora_inicio`, `hora_fin`, `tipo_sesion`, `ciclo`, `aforo_covid`) 
                                        VALUES ('50', '$codcurso', '$curso', '$seccion', '$campus', '$aula', '$dia', '$hora_inicio', '$hora_fin', '$tipo', '$ciclo', '$aforo')";
                                
                                try{
                                    $obj = $pdo -> prepare($sql5);
                                    $obj -> execute();
                                    echo "<script language=javascript> alert('Se ha ingresado la seccion correctamente. El aula tiene un aforo de ".$aforo.". ');</script>"; 
                                } catch(Exception $ex){
                                    echo "<script language=javascript> alert('Error al insertar la seccion.');</script>"; 
                                }


                            } else{
                                echo "<script language=javascript> alert('Este nombre de seccion ya está tomado.');</script>";
                            }

                        } else{ //hay cruce, envia alert
                            echo "<script language=javascript> alert('Existe un cruce. Intente con un nuevo horario o una nueva aula.');</script>";
                        }

                        
                        // -------------- BOTON  EDITAR ------------------
                    } else if(isset($_POST['editar'])){
                        echo "<script language=javascript>self.location = 'crea_secc_edit.php'; </script>";
                       
                        

                        // -------------- BOTON  BUSCAR ------------------
                    } else if(isset($_POST['buscar'])){
                        return;
                    }
                


            } 
        ?>

    </body>
</html>