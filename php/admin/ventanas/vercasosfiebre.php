<!DOCTYPE html>
    <html lang="en">
    <div class="container" id="ver_casos_fiebre" style="margin-top:40px;">
        <h2 class="h2 text-center">Casos de fiebre UPC</h2>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="campus3" style="width: 25%; margin-left: auto; margin-right: auto;">
                        <option selected>Campus</option>
                        <option value="MO">MO</option>
                        <option value="SM">SM</option>
                        <option value="SI">SI</option>
                        <option value="VI">VI</option>
                    </select>
                </div>
                <div class="col">
                    <button class="btn-primary btn-lg" type="submit" style="background-color: rgb(187, 3, 3);
                font-family: 'Trebuchet MS'; border-color: darkred; margin-right: auto; height: 80%;">Buscar</button>
                </div>
            </div>
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['campus3'])){
                $campus = $_POST['campus3'];
                $estadov3 = 1;
        ?>

                <table class="table table-bordered text-center">
                    <thead>
                        <th>Curso</th>
                        <th>Hora de entrada</th>
                        <th>Hora de salida</th>
                        <th>C&oacute;digo</th>
                        <th>Secci&oacute;n</th>
                        <th>Temperatura</th>
                    </thead>

                    <tbody>
                        <?php
                            //header("Content-Type: text/html;charset=utf-8");
                            date_default_timezone_set("America/Lima");
                            $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
                            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT DT.idsesion, DT.curso, a.hora_entrada, 
                                            a.hora_salida, a.codigo, DT.seccion, a.temperatura 
                                    FROM asistencia a INNER JOIN 
                                                            ( SELECT p.idsesion, c.curso, c.seccion, c.campus 
                                                            FROM cursos c INNER JOIN programacion p ON c.id = p.id) DT 
                                    ON DT.idsesion = a.idsesion WHERE DT.campus = '$campus' AND a.temperatura >=37";

                            try{
                                $obj = $pdo -> prepare($sql);
                                $obj -> execute();
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar aulas.');".
                                    "self.location='../../cerrar.php'</script>"; 
                            }

                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<tr>";
                                echo "<td>".$curso."</td>"; 
                                echo "<td>".$hora_entrada."</td>";
                                echo "<td>".$hora_salida."</td>";
                                echo "<td>".$codigo."</td>"; 
                                echo "<td>".$seccion."</td>";
                                echo "<td>".$temperatura."</td>"; 
                                echo "</tr>";
                            }


                        ?>

                    </tbody>
                </table>

        <?php
            } else{
                $estadov3 = 0;
            }
        ?>


        

    </div>

</html>