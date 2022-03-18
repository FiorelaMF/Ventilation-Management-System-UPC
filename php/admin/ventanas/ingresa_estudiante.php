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
    <div class="container" style="margin-top:10px;">
        
        <h2 class="h2 text-center">Ingresar nuevo/a estudiante</h2>
        <br>

        <form class="form-group" method="POST">
            <br>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Carrera</th>
                        <th>Sexo</th>
                        <th>Campus</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="codigo" maxlength="10"></td>
                        <td><input type="text" class="form-control" name="nombre"></td>
                        <td><input type="text" class="form-control" name="apellidop"></td>
                        <td><input type="text" class="form-control" name="apellidom"></td>
                        <td><select class="form-select" aria-label="Default select example" name="carrera">
                            <option selected>Carrera</option>
                                <?php
                                    $sql = "SELECT DISTINCT(carrera) FROM personal";

                                    try{
                                        $obj = $pdo -> prepare($sql);
                                        $obj -> execute();
                                    } catch(Exception $ex){
                                        echo "<script languaje=javascript> alert('Error al buscar carreras.');</script>"; 
                                    }
                                    
                                    while($row = $obj -> fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        $carrera = utf8_encode($row['carrera']);
                                        echo "<option value='$carrera'>".$carrera."</option>";
                                    } 
                                
                                ?>
                        </select></td>
                        <td><select class="form-select" aria-label="Default select example" name="sexo">
                            <option selected>Sexo</option>
                            <option value="F">F</option>
                            <option value="M">M</option>
                        </select></td>
                        <td><select class="form-select" aria-label="Default select example" name="campus">
                            <option selected>Campus</option>
                            <option value="MO">MO</option>
                            <option value="SM">SM</option>
                            <option value="SI">SI</option>
                            <option value="VI">VI</option>
                        </select></td>
                        
                    </tr>
                </tbody>
            </table>

            <br><br>
            <div class="row">
                <div class="col-6" style="text-align: center">
                    <button class="btn-primary btn-lg" type="submit" name="crear" id="grab-btn">CREAR</button>
                </div>
                <div class="col-6" style="text-align: center">
                    <button class="btn-primary btn-lg" type="submit" name="editar" id="grab-btn">EDITAR</button>
                </div>
            </div>
        </form>


        <?php
            if (isset($_POST['crear'])){
                $codigo = $_POST['codigo'];
                $nombre = utf8_decode($_POST['nombre']);
                $apellidop = utf8_decode($_POST['apellidop']);
                $apellidom = utf8_decode($_POST['apellidom']);
                $carrera = utf8_decode($_POST['carrera']);
                $sexo = $_POST['sexo'];
                $campus = $_POST['campus'];

                //verifica que el codigo este correcto
                if((substr($codigo, 0, 6) ==='u20212') || (substr($codigo, 0, 6) === 'U20212')){
                    // verifica que el codigo no se repita
                    $sql = "SELECT codigo FROM personal WHERE estado = 'ALUMNO' AND codigo = '$codigo'";

                    try{
                        $obj = $pdo -> prepare($sql);
                        $obj -> execute();
                        $row = $obj -> fetch(PDO::FETCH_ASSOC);
                    } catch(Exception $ex){
                        echo "<script languaje=javascript> alert('Error al buscar codigo.');</script>"; 
                    }
                                    
                    if(empty($row)){
                        // no es codigo repetido, INSERTAR
                        $sql = "INSERT INTO `personal` (`codigo`, `nombre`, `apellidop`, `apellidom`, `carrera`, `sexo`, `campus`, `estado`) 
                                VALUES ('$codigo', '$nombre', '$apellidop', '$apellidom', '$carrera', '$sexo', '$campus', 'ALUMNO')";

                        try{
                            $obj = $pdo -> prepare($sql);
                            $obj -> execute();
                            echo "<script languaje=javascript> alert('Se ha ingresado al estudiante correctamente.');</script>"; 
                        } catch(Exception $ex){
                            echo "<script languaje=javascript> alert('Error al ingresar estudiante. Verificar datos.');</script>"; 
                        }

                    } else{
                        // repetido
                        echo "<script languaje=javascript> alert('Codigo ya existente. Ingrese otro diferente.');</script>"; 
                    }

                } else{
                    echo "<script languaje=javascript> alert('El codigo debe empezar con u20212');</script>"; 
                }
               

            } else if(isset($_POST['editar'])){
                echo "<script language=javascript>self.location = 'estudiante_edit.php'; </script>";
            }
        ?>

    </div>

    </body>
</html>