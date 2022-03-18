
<!DOCTYPE html>
    <html lang="en">

    <div class="container" id="ver_vent_alum" style="margin-top:30px;">
        <h3 class="h2 text-center">Ventilaci&oacute;n de las sesiones</h3>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="curso2">
                        <option selected>Curso</option>
                        <?php
                            $sql = "SELECT DISTINCT(c.curso), c.codcurso FROM cursos c 
                                    INNER JOIN matriculados m ON m.id = c.id WHERE m.codalumno = '$usuario'";
        
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
                    <button class="btn-primary btn-lg" type="submit">Buscar</button>
                </div>  
            </div>
        </form>
                        

        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['curso2'])){
                $estado2 = 1;
                
                    $codcurso = $_POST['curso2'];

                    // DISTINCT de secciones
                    $sql = "SELECT DT.id, DT.idsesion, DT.fecha, c.curso, c.seccion, c.aula, c.campus, c.aforo_covid, c.hora_inicio, c.hora_fin 
                            FROM cursos c INNER JOIN( 
                                                    SELECT p.idsesion, p.fecha, m.id, m.codalumno 
                                                    FROM matriculados m INNER JOIN programacion p ON p.id = m.id 
                                                    WHERE m.codalumno = '$usuario') DT 
                            ON c.id = DT.id WHERE c.codcurso = '$codcurso' ORDER BY DT.fecha DESC";
                    
                    try{
                        $obj = $pdo -> prepare($sql);
                        $obj -> execute();
                    } catch(Exception $ex){
                        echo "<script languaje=javascript> alert('Error buscando tabla de aulas.');".
                            "self.location='../../cerrar.php'</script>"; 
                    }

                    // IMPRIMIMOS HEADER DE LA TABLA
                    echo "<br><table class='table table-bordered text-center'>";
                    echo "<thead>";
                    echo "<th>Fecha</th>";
                    echo "<th>Curso</th>";
                    echo "<th>Secci&oacute;n</th>";
                    echo "<th>Aula</th>";
                    echo "<th>Campus</th>";
                    echo "<th>Aforo</th>";
                    echo "<th>Ventilaci&oacute;n</th>";
                    echo "</thead>";

                    echo "<tbody>";

                    // IMPRIMIMOS DATOS DE LA TABLA
                    while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                        extract($row);  
                        echo "<tr>";
                        echo "<td>".$fecha."</td>";
                        echo "<td>".utf8_encode($curso)."</td>";
                        echo "<td>".utf8_encode($seccion)."</td>";
                        echo "<td>".$aula."</td>";
                        echo "<td>".$campus."</td>";
                        echo "<td>".$aforo_covid."</td>";
                        echo "<td><form action='ventanas/vent2.php' method='POST'>".
                                    "<button class='btn-primary' type='submit' style='background-color: gray; border-color: darkgray;'>Ver</button>".
                                    "<input name='curso' value='$curso' type='hidden'/><input name='seccion' value='$seccion' type='hidden'/>".
                                    "<input name='aula' value='$aula' type='hidden'/>"."<input name='hora_inicio' value='$hora_inicio' type='hidden'/>".
                                    "<input name='hora_fin' value='$hora_fin' type='hidden'/>"."<input name='fecha' value='$fecha' type='hidden'/>".
                                    "<input name='idsesion' value='$idsesion' type='hidden'/>"."</form></td>";
                        echo "</tr>";
                    }

                    
                    echo "</tbody>";
                    echo "</table>";

            }  else{
                $estado2 = 0;
            }

        ?>

    </div>


</html>