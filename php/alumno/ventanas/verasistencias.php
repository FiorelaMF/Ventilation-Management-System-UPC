<?php
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
?>


<!DOCTYPE html>
    <html lang="en">

    <div class="container" id="ver_asist_alum" style="margin-top:40px;">
        <h3 class="h2 text-center">Mis asistencias</h3>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="curso">
                        <option selected>Curso</option>
                        <?php
                            $sql = "SELECT DISTINCT(c.curso), c.seccion, c.codcurso FROM cursos c 
                            INNER JOIN matriculados m ON m.id = c.id WHERE m.codalumno = '$usuario'";
        
                            try{
                                $obj = $pdo -> prepare($sql);
                                $obj -> execute();
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar cursos.');"; 
                            }

                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='".$seccion."'>".$curso."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col">
                    <button class="btn-primary btn-lg" type="submit">Buscar</button>
                </div>  
            </div>
        </form>
                        

        <?php
            
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['curso'])){
                    $estado1 = 1;
                    $seccion = $_POST['curso'];
                    

                    // DISTINCT de secciones
                    $sql2 = "SELECT a.idsesion, DT.id, DT.aula, DT.curso, DT.fecha, a.hora_entrada, a.hora_salida, a.estado, a.temperatura FROM asistencia a INNER JOIN ( SELECT p.idsesion, p.id, c.aula, c.curso, p.fecha, c.seccion FROM programacion p INNER JOIN cursos c ON p.id = c.id WHERE c.seccion = 'LS92') DT ON DT.idsesion = a.idsesion WHERE a.codigo = 'u201810100' ORDER BY DT.fecha DESC";

                    
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
                        

                            try{
                                $obj_tabla = $pdo -> prepare($sql2);
                                $obj_tabla -> execute();
                            } catch(Exception $ex){
                                //echo $sql3;
                                echo "<script languaje=javascript> alert('Error buscando asistencia.');</script>;"; 
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
                                echo "<td><form action='ventanas/vent2.php' method='POST'>".
                                    "<button class='btn-primary' type='submit' style='background-color: gray; border-color: darkgray;'>Ver</button>".
                                    "<input name='curso' value='$curso' type='hidden'/><input name='seccion' value='$seccion' type='hidden'/>".
                                    "<input name='aula' value='$aula' type='hidden'/>"."<input name='hora_inicio' value='$hora_entrada' type='hidden'/>".
                                    "<input name='hora_fin' value='$hora_salida' type='hidden'/>"."<input name='fecha' value='$fecha' type='hidden'/>".
                                    "<input name='idsesion' value='$idsesion' type='hidden'/>"."</form></td>";
                                echo "</tr>";
                            }
                        echo "</tbody>";
                        echo "</table>";

                    

            } else{
                $estado1 = 0;
            }

        ?>

    </div>


</html>
