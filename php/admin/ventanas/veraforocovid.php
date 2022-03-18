<!DOCTYPE html>
    <html lang="en">
    <div class="container" id="ver_aforo_covid" style="margin-top:40px;">
        <h2 class="h2 text-center">Visualizaci&oacute;n del aforo COVID de las aulas</h2>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="campus" style="width: 25%; margin-left: auto; margin-right: auto;">
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
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['campus'])){
                $campus = $_POST['campus'];
                $estadov2 = 1;
        ?>

                <table class="table table-bordered text-center">
                    <thead>
                        <th>Aula</th>
                        <th>Campus</th>
                        <th>Ciclo</th>
                        <th>Aforo</th>
                        <th>Acci&oacute;n</th>
                    </thead>

                    <tbody>
                        <?php
                            //header("Content-Type: text/html;charset=utf-8");
                            date_default_timezone_set("America/Lima");
                            $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
                            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT DISTINCT(aula), campus, aforo_covid FROM cursos WHERE ciclo='2021-2' AND campus='$campus'";

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
                                echo "<td>".$aula."</td>"; 
                                echo "<td>".$campus."</td>";
                                echo "<td>2021-2</td>";
                                echo "<td>".$aforo_covid."</td>"; 
                                echo "<td><form action='ventanas/cambiar_aforo.php' method='POST'><button class='btn-primary' type='submit'>Cambiar</button><input name='aula' value='$aula' type='hidden'/><input name='campus' value='$campus' type='hidden'/><input name='aforo' value='$aforo_covid' type='hidden'/></form></td>"; 
                                echo "</tr>";
                            }


                        ?>

                    </tbody>
                </table>

        <?php
            } else{
                $estadov2 = 0;
            }
        ?>


        

    </div>

</html>
