<?php
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
?>


<!DOCTYPE html>
    <html lang="en">

    <div class="container" id="ver_mis_asist" style="margin-top:40px;">
        <h3 class="h2 text-center">Mis asistencias</h3>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="curso">
                        <option selected>Curso</option>
                        <?php
                            $sql = "SELECT DISTINCT(curso), codcurso 
                            FROM cursos 
                            INNER JOIN programacion ON programacion.id = cursos.id 
                            WHERE programacion.coddocente = '$usuario'";
        
                            try{
                                $obj = $pdo -> prepare($sql);
                                $obj -> execute();
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar aulas.');".
                                    "self.location='../../cerrar.php'</script>"; 
                            }

                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='".$codcurso."'>".$curso."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col">
                    <button class="btn-primary btn-lg" type="submit" id="buscar_misAsist">Buscar</button>
                </div>  
            </div>
        </form>
                        

        <?php
            
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['curso'])){
                    $estado1 = 1;
                    $codcurso = $_POST['curso'];
                    

                    // DISTINCT de secciones
                    $sql2 = "SELECT DISTINCT(seccion), c.curso 
                            FROM cursos c INNER JOIN programacion p ON p.id = c.id 
                            WHERE c.codcurso = '$codcurso' AND p.coddocente = '$usuario'";
                    $secciones = array();
                    try{
                        $obj2 = $pdo -> prepare($sql2);
                        $obj2 -> execute();
                    } catch(Exception $ex){
                        echo "<script languaje=javascript> alert('Error buscando seccion.');".
                            "self.location='../../cerrar.php'</script>"; 
                    }

                    // SACAR LA DATA DE LA TABLA E IDENTIFICAR SECCION
                    while($row2 = $obj2->fetch(PDO::FETCH_ASSOC)){
                        extract($row2);
                        array_push($secciones, $seccion);
                    }

                    // CREAMOS TABLA X SECCION
                    foreach($secciones as &$seccion){
                        echo "<br><h4>Curso: <b>".$curso."</b> | Secci&oacute;n: <b>". $seccion. "</b></h4>";
                        echo "<table class='table table-bordered text-center'>";
                        echo "<thead>";
                        echo "<th>Fecha</th>";
                        echo "<th>Hora de entrada</th>";
                        echo "<th>Hora de salida</th>";
                        echo "<th>Asistencia</th>";
                        echo "<th>Temperatura</th>";
                        echo "<th>Ventilaci&oacute;n</th>";
                        echo "</thead>";

                        echo "<tbody>";
                        /*
                        $sql3 = "SELECT a.idsesion, DT.id, DT.fecha, a.hora_entrada, 
                                    a.hora_salida, a.estado, a.temperatura, DT.codcurso, DT.campus 
                                FROM asistencia a 
                                INNER JOIN 
                                    (SELECT idsesion, p.id, fecha, coddocente, codcurso, campus, c.seccion 
                                    FROM programacion p 
                                    INNER JOIN cursos c 
                                    ON p.id = c.id WHERE coddocente = '$usuario') DT 
                                ON a.idsesion = DT.idsesion 
                                WHERE DT.codcurso = '$codcurso' AND DT.seccion='$seccion' 
                                ORDER BY DT.id"; */

                        $sql3 = "SELECT a.idsesion, DT.id, DT.fecha, a.hora_entrada, 
                                 a.hora_salida, a.estado, a.temperatura, DT.codcurso, 
                                 DT.campus, DT.curso, DT.aula, DT.hora_inicio, DT.hora_fin 
                                 FROM asistencia a INNER JOIN 
                                    (SELECT idsesion, p.id, fecha, coddocente, 
                                        codcurso, campus, c.seccion, c.curso, 
                                        c.aula, c.hora_inicio, c.hora_fin 
                                    FROM programacion p INNER JOIN cursos c ON p.id = c.id 
                                    WHERE coddocente = '$usuario') DT 
                                 ON a.idsesion = DT.idsesion 
                                 WHERE DT.codcurso = '$codcurso' AND DT.seccion='$seccion' ORDER BY DT.id";

                            try{
                                $obj_tabla = $pdo -> prepare($sql3);
                                $obj_tabla -> execute();
                            } catch(Exception $ex){
                                //echo $sql3;
                                echo "<script languaje=javascript> alert('Error buscando asistencia.');".
                                  "self.location='../../cerrar.php'</script>"; 
                            }
                            
                            while($row3 = $obj_tabla->fetch(PDO::FETCH_ASSOC)){
                                extract($row3);
                                echo "<tr>";
                                echo "<td>".$fecha."</td>";
                                echo "<td>".$hora_entrada."</td>";
                                echo "<td>".$hora_salida."</td>";
                                echo "<td>".utf8_encode($estado)."</td>";
                                echo "<td>".$temperatura."</td>"; 
                                //curso, seccion, aula, horario, fecha
                                echo "<td><form action='ventanas/vent_btn1.php' method='POST'>".
                                    "<button class='btn-primary' type='submit' style='background-color: gray; border-color: darkgray;'>Ver</button>".
                                    "<input name='curso' value='$curso' type='hidden'/><input name='seccion' value='$seccion' type='hidden'/>".
                                    "<input name='aula' value='$aula' type='hidden'/>"."<input name='hora_inicio' value='$hora_inicio' type='hidden'/>".
                                    "<input name='hora_fin' value='$hora_fin' type='hidden'/>"."<input name='fecha' value='$fecha' type='hidden'/>".
                                    "<input name='idsesion' value='$idsesion' type='hidden'/>"."</form></td>";
                                echo "</tr>";
                            }
                        echo "</tbody>";
                        echo "</table>";

                    }

            } else{
                $estado1 = 0;
            }

        ?>

    </div>


</html>
