<!DOCTYPE html>
<html lang="en">
    <style>
        #enviar{
            background-color: rgb(187, 3, 3);
            font-family: 'Trebuchet MS';
            border-color: darkred; 
        }
    </style>
    <body>
    <div class="container" id="ingresa_doc_nuevo" style="margin-top:40px;">
        <h2 class="h2 text-center">Ingresar docente nuevo</h2>
        <br>
        <h4>Ingrese los siguientes datos</h4>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col">
                    <label class="form-label">Nombres:</label>
                    <input type="text" class="form-control" name="nombre">    
                </div>
                <div class="col">
                    <label class="form-label">Apellido paterno:</label>
                    <input type="text" class="form-control" name="apellidop">    
                </div>
                <div class="col">
                    <label class="form-label">Apellido materno:</label>
                    <input type="text" class="form-control" name="apellidom">    
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-4">
                    <select class="form-select" aria-label="Default select example" name="carrera">
                        <option selected>Carrera</option>
                        <?php
                            $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
                            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT DISTINCT(carrera) FROM personal";
                            try{
                                $obj = $pdo -> prepare($sql);
                                $obj -> execute();
                            } catch(Exception $ex){
                                echo "<script languaje=javascript> alert('Error al buscar carreras.');".
                                    "self.location='../../cerrar.php'</script>"; 
                            }

                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                $carrera = utf8_encode($carrera);
                                echo "<option value='$carrera'>".$carrera."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col-3">
                    <label class="form-label">Sexo:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="M" id="sexo1">
                        <label class="form-check-label" for="sexo1">
                            M
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="F" id="sexo2" checked>
                        <label class="form-check-label" for="sexo2">
                            F
                        </label>
                    </div>
                </div>

                <div class="col-3">
                <button class="btn-primary btn-lg" type="submit" id="enviar">Enviar</button>
                </div>
            </div>

        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['nombre']) && isset($_POST['apellidop']) && isset($_POST['apellidom']) && isset($_POST['carrera']) && isset($_POST['sexo'])){
                $estadoc1 = 1;

                $nombre =  utf8_decode($_POST['nombre']);
                $apellidop = utf8_decode($_POST['apellidop']);       $apellidom = utf8_decode($_POST['apellidom']);     
                $carrera = utf8_decode($_POST['carrera']);           $sexo = $_POST['sexo'];
                $codigo_new = strtolower( explode(" ",$nombre)[0] . "." . implode("",explode(" ", $apellidop)));

                // Verificar que no este en la db already
                $sql = "SELECT * FROM personal WHERE codigo = '$codigo_new'";
                try{
                    $obj = $pdo -> prepare($sql);
                    $obj -> execute();
                    $row = $obj->fetch(PDO::FETCH_ASSOC);
                } catch(Exception $ex){
                    echo "<script languaje=javascript> alert('Error al buscar carreras.')</script>;"; 
                }

                if(empty($row)){
                    // no esta en la db
                    $sql_ins = "INSERT INTO `personal` (`codigo`, `nombre`, `apellidop`, `apellidom`, `carrera`, `sexo`, `campus`, `estado`) 
                                            VALUES ('$codigo_new', '$nombre', '$apellidop', '$apellidom', '$carrera', '$sexo', NULL, 'DOCENTE')";
                    echo "<script language=javascript>console.log('Ingresa al if empty.')</script>";
                    
                    try{
                        $obj2 = $pdo -> prepare($sql_ins);
                        $obj2 -> execute();

                        echo "<script language=javascript> alert('Docente ingresado correctamente.')</script>"; 
                        echo "<br><label>C&oacute;digo generado: <b>".$codigo_new."</b></label>";
                        echo "<script language=javascript>console.log('si ingresa');</script>";
                    } catch(Exception $ex){
                        echo "<script language=javascript> alert('Error al ingresar datos del docente.')</script>"; 
                    }
                
                } else{
                    // SI esta en la db, ALERT
                    echo "<script language=javascript> alert('Esta persona ya se encuentra registrada.')</script>";
                    echo "<script language=javascript>console.log('no ingresa al if empty')</script>";
                }

            } else{
                $estadoc1 = 0;
            }
        ?>
        
        

    </div>
    </body>
</html>