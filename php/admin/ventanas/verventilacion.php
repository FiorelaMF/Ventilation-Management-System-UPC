
<!DOCTYPE html>
    <html lang="en">
    <meta charset="utf-8">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes"> 
    
    <div class="container" id="ver_vent_tabla" style="margin-top:40px;">
    <button onclick='volver()' style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Volver al men&uacute; </button>
        <h2 class="h2 text-center">Visualizaci&oacute;n del ventilación de las aulas</h2>
        <br>
        <script language="javascript">
            function reload(form){
                //var v1=document.getElementById('s1').value();
                var v1=form.campus.options[form.campus.options.selectedIndex].value;
                self.location = 'verventilacion.php?campus='+v1;
            }
            function volver(){
                self.location='../menuadmin.php';
            }
        </script>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="campus"  id='s1' onChange='reload(this.form)'>
                        <option selected>Campus</option>
                        <option value="MO">MO</option>
                        <option value="SM">SM</option>
                        <option value="SI">SI</option>
                        <option value="VI">VI</option>
                    </select>
                </div>

                <div class="col">
                        <?php
                            if( isset($_GET['campus'])){
                                $campus = $_GET['campus'];
                            }

                            $mysqli = new mysqli('localhost', 'root', '', 'sotr');

                            $sql = "SELECT DISTINCT(aula) FROM cursos WHERE campus = ? ORDER BY aula";
                            $stmt = $mysqli->prepare($sql);

                            if($stmt = $mysqli -> prepare($sql)){
                                $stmt -> bind_param('s', $campus);
                                $stmt -> execute();
                                $result = $stmt -> get_result();
                            
                                echo "<select class='form-select' aria-label='Default select example' id='s2' name='aula'>";
                                echo "<option selected>Aula</option>";

                                while($row = $result->fetch_assoc()){
                                    extract($row);
                                    echo "<option value='".$aula."'>".$aula."</option>";
                                }
                                echo "</select>";
                            }
                            
                        ?>
                    
                </div>

                <div class="col">
                    <div class="md-form">
                        <input placeholder="Fecha [yyyy-mm-dd]" type="text" name="fecha_vent" class="form-control datepicker">
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <button class="btn-primary btn-lg" type="submit" id="buscar_vent" style="background-color: rgb(187, 3, 3);
            font-family: 'Trebuchet MS'; border-color: darkred; ">Buscar</button>
            </div>
        </form>

        <?php
            // EMPEZAMOS CON EL POST
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['campus']) && isset($_POST['aula']) && isset($_POST['fecha_vent'])){
                //$campus = $_POST['campus'];
                $aula = $_POST['aula'];
                $fecha_vent = $_POST['fecha_vent'];
        ?>

        <br>
        <div id = "tabla_vent">
            <table class="table table-bordered text-center">
                <thead>
                    <th>Curso</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Asistentes</th>
                    <th>Secci&oacute;n</th>
                    <th>Ventilaci&oacute;n</th>
                </thead>

                <tbody>
                    <?php
                        //$pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
                        //$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $sql_tab = "SELECT DT.idsesion, c.curso, c.hora_inicio, c.hora_fin, DT.asistentes, c.seccion 
                                    FROM cursos c CROSS JOIN 
                                                    (SELECT p.idsesion, p.id, p.fecha, CT.asistentes 
                                                    FROM programacion p INNER JOIN 
                                                                            (SELECT idsesion, COUNT(*) AS asistentes 
                                                                            FROM asistencia WHERE estado='Asistió' 
                                                                            GROUP BY idsesion) CT ON p.idsesion = CT.idsesion 
                                                                            WHERE p.fecha = '$fecha_vent' GROUP BY p.idsesion) DT 
                                    ON c.id = DT.id WHERE c.campus = '$campus' AND c.aula = '$aula'";

                        try{
                            $result2 = $mysqli->query($sql_tab) or die($mysqli->error.__LINE__);
                            $row2 = $result2->fetch_assoc();
                            /*
                            $stmt = $mysqli -> prepare($sql_tab);
                            $stmt -> execute();
                            $result2 = $stmt -> get_result();
                            $row2 = $result2->fetch_assoc();
                            extract($row2);
                            echo $sql_tab;*/
                            
                            
                        } catch(Exception $ex){
                            echo "<script language=javascript> alert('Error al buscar datos de ventilacion.')</script>;"; 
                        }

                            while($row2 = $result2->fetch_assoc()){
                                extract($row2);
                                echo $sql_tab;
                                echo "<script language=javascript>console.log('llega aqui')</script>";
                                echo "<tr>";
                                echo "<td>".$row2['curso']."</td>";
                                echo "<td>".$row2['hora_inicio']."</td>";
                                echo "<td>".$row2['hora_fin']."</td>";
                                echo "<td>".$row2['asistentes']."</td>";
                                echo "<td>".$row2['seccion']."</td>";
                                //curso, hora_ini, hora_fin, asistentes, seccion
                                echo "<td><form action='ventanas/btn_vent1.php' method='POST'>"/*.
                                        "<button class='btn-primary' type='submit' style='background-color: gray; border-color: darkgray;'>Ver</button>".
                                        "<input name='curso' value='$curso' type='hidden'/><input name='seccion' value='$seccion' type='hidden'/>".
                                        "<input name='aula' value='$aula' type='hidden'/>"."<input name='hora_inicio' value='$hora_inicio' type='hidden'/>".
                                        "<input name='hora_fin' value='$hora_fin' type='hidden'/>"."<input name='fecha' value='$fecha_vent' type='hidden'/>".
                                        "<input name='idsesion' value='$idsesion' type='hidden'/>"."</form></td>"*/;
                                echo "</tr>";
                            }
                        

                        /*
                        try{
                            $obj = $pdo -> prepare($sql_tab);
                            $obj -> execute();
                        } catch(Exception $ex){
                            echo "<script languaje=javascript> alert('Error al buscar datos de ventilacion.');"; 
                        }

                        while($row2 = $obj->fetch(PDO::FETCH_ASSOC)){
                            extract($row2);
                            echo $sql;
                            echo $curso;
                            echo "<tr>";
                            echo "<td>".$curso."</td>";
                            echo "<td>".$hora_inicio."</td>";
                            echo "<td>".$hora_fin."</td>";
                            echo "<td>".$asistentes."</td>";
                            echo "<td>".$seccion."</td>";
                            //curso, hora_ini, hora_fin, asistentes, seccion
                            echo "<td><form action='ventanas/btn_vent1.php' method='POST'>".
                                    "<button class='btn-primary' type='submit' style='background-color: gray; border-color: darkgray;'>Ver</button>".
                                    "<input name='curso' value='$curso' type='hidden'/><input name='seccion' value='$seccion' type='hidden'/>".
                                    "<input name='aula' value='$aula' type='hidden'/>"."<input name='hora_inicio' value='$hora_inicio' type='hidden'/>".
                                    "<input name='hora_fin' value='$hora_fin' type='hidden'/>"."<input name='fecha' value='$fecha_vent' type='hidden'/>".
                                    "<input name='idsesion' value='$idsesion' type='hidden'/>"."</form></td>";
                            echo "</tr>";
                        } */
                    ?>

                </tbody>
            </table>
        </div>

        <?php
            }
        ?>

    </div>
</html>