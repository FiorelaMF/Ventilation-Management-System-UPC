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
            function volver(){
                self.location='../menuadmin.php';
            }
    </script>

    <body>
    <button onclick='volver()' style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Volver al men&uacute; </button>
    <div class="container" style="margin-top:10px;">
        
        <h2 class="h2 text-center">Editar datos del estudiante</h2>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col-4"> <label class="form-label">C&oacute;digo</label> </div>
                <div class="col-4"> <label class="form-label">Nombre</label> </div>
                <div class="col-4"> <label class="form-label">Apellido paterno</label> </div>
            </div>
            <div class="row">
                <div class="col-4"> <input type="text" class="form-control" name="codigo" style="width: 70%;"> </div>
                <div class="col-4"> <input type="text" class="form-control" name="nombre" style="width: 70%;"> </div>
                <div class="col-4"> <input type="text" class="form-control" name="apellidop" style="width: 70%;"> </div>
            </div>   
            
            <br>
            <button class="btn-primary btn-lg" type="submit" name="buscar" id="grab-btn">BUSCAR</button>
            <br>
        </form>

    </div>

    <?php
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['buscar'])){
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $apellidop = $_POST['apellidop'];

            if ($codigo != ''){
                $cod_qry = "codigo = '$codigo'";
            } else{
                $cod_qry = "1";
            }

            if ($nombre != ''){
                $nomb_qry = "nombre = '$nombre'";
            } else{
                $nomb_qry = "1";
            }

            if ($apellidop != ''){
                $apllp_qry = "apellidop = '$apellidop'";
            } else{
                $apllp_qry = "1";
            }

            $sql = "SELECT * FROM personal WHERE estado = 'ALUMNO' AND ".$cod_qry." AND ".$nomb_qry." AND ".$apllp_qry ;


            ?>
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
                        <th>Grabar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>

                <form class="form-group" method="POST">
                    <?php
                        $obj = $pdo -> prepare($sql);
                        $obj -> execute();
                        while($row = $obj -> fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                            $nombre = utf8_encode($nombre);
                            $apellidop = utf8_encode($apellidop);
                            $apellidom = utf8_encode($apellidom);
                            $carrera = utf8_encode($carrera);
                            echo "<tr>";
                            echo "<td>".$codigo."<input value='$codigo' name='codigo' type='hidden'/></td>";   
                            echo "<td><input class='form-control text-center' type='text' value='$nombre' name='nombre'/></td>";
                            echo "<td><input class='form-control text-center' type='text' value='$apellidop' name='apellidop'/></td>";
                            echo "<td><input class='form-control text-center' type='text' value='$apellidom' name='apellidom'/></td>";
                            echo "<td><input class='form-control text-center' type='text' value='$carrera' name='carrera'/></td>";
                            echo "<td><select class='form-select' aria-label='Default select example' value='$sexo' name='sexo'>".
                                "<option value='M'>M</option> <option value='F'>F</option> </select></td>";
                            echo "<td><select class='form-select' aria-label='Default select example' value='$campus' name='campus'>".
                                    "<option value='MO'>MO</option> <option value='SM'>SM</option>".
                                    "<option value='SI'>SI</option> <option value='VI'>VI</option>" .
                                    "</select></td>";
                            echo "<td><button class='bt-primary' type='submit' name='grabar'>Grabar</button></td>";
                            echo "<td><button class='bt-primary' type='submit' name='eliminar'>Eliminar</button></td>";
                            echo "</tr>";
                        }
                    ?>
                
                </form>
                </tbody>
            </table>
            <?php
        }

        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['grabar'])){
            extract($_POST);
            $carrera = utf8_decode($carrera);
            $sql = "UPDATE personal SET nombre = '$nombre', apellidop = '$apellidop', apellidom = '$apellidom', 
                     carrera = '$carrera', sexo = '$sexo', campus = '$campus' 
                    WHERE codigo='$codigo'";
            
            try{
                $obj = $pdo -> prepare($sql);
                $obj -> execute();
                echo "<script language=javascript> alert('Se actualizaron los datos correctamente.'); </script>"; 
            } catch(Exception $ex){
                echo "<script language=javascript> alert('Error al actualizar datos.'); </script>"; 
            }

        }
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['eliminar'])){
            extract($_POST);
            $sql = "DELETE FROM personal WHERE codigo='$codigo'";
            
            try{
                $obj = $pdo -> prepare($sql);
                $obj -> execute();
                echo "<script language=javascript> alert('Se eliminó este elemento correctamente.'); </script>"; 
            } catch(Exception $ex){
                echo "<script language=javascript> alert('Error al eliminar este elemento.'); </script>"; 
            }

        }
    ?>

    </body>

</html>