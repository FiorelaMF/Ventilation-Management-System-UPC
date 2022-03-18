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
        #grab-btn{
            background-color: rgb(187, 3, 3);
            font-family: 'Trebuchet MS';
            border-color: darkred; 
            width: 40%;
            height: 80%;
        }
        h2{
            text-align: center;
        }

    </style>

    <script language="javascript">
            function reload(form){
                //var v1=document.getElementById('s1').value();
                var v1=form.campus5.options[form.campus5.options.selectedIndex].value;
                self.location = 'crear_seccion.php?campus5='+v1;
            }
            function volver(){
                self.location='../menuadmin.php';
            }
    </script>

    <body>
    <button onclick='volver()' style="background-color: '#f8ffef'; border-width: 0px; height: 50px; color: rgb(187, 3, 3);"> << Volver al men&uacute; </button>
    <div class="container" style="margin-top:5px;">
        <h2>Editar secci&oacute;n</h2>
        
        <br>
        <div class="row">
            <div class="col-1">
                <label class="form-label">Campus</label>
            </div>
            <div class="col-5">
                <select class="form-select" aria-label="Default select example" name="campus5" id='s1' onChange='reload(this.form)' style="margin-left: 0px; width: 50%;">
                    <option selected>Campus</option>
                    <option value="MO">MO</option>
                    <option value="SM">SM</option>
                    <option value="SI">SI</option>
                    <option value="VI">VI</option>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label">Ciclo</label>
            </div>
            <div class="col-5">
                <select class="form-select" aria-label="Default select example" name="ciclo" style="margin-left: 0px; width: 50%;">
                    <option selected>Ciclo</option>
                    <option value="2021-2">2021-2</option>
                    <option value="2022-0">2022-0</option>
                    <option value="2022-1">2022-1</option>
                </select>
            </div>
        </div>

        <br>
        <div class="row">
        <div class="col-1">
                <label class="form-label">Carrera</label>
            </div>
            <div class="col-5">
                <select class="form-select" aria-label="Default select example" name="carrera" id='s2' style="margin-left: 0px; width: 50%;">
                    <option selected>Carrera</option>
                    <?php
                        if( isset($_GET['campus5'])){
                            $campus = $_GET['campus5'];
                            $sql = "SELECT DISTINCT(carrera) FROM cursos WHERE campus=?";

                            $obj = $pdo -> prepare($sql);

                            $obj -> bindParam(1, $campus, PDO::PARAM_STR, 5);
                            $obj -> execute();
                            
                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='$carrera'>".utf8_encode($carrera)."</option>";
                            } 
                        }

                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label">Curso</label>
            </div>
            <div class="col-5">
                <select class="form-select" aria-label="Default select example" name="curso" style="margin-left: 0px; width: 50%;">
                    <option selected>Curso</option>
                    <?php
                        if( isset($_GET['carrera'])){
                            $campus = $_GET['carrera'];
                            $sql = "SELECT DISTINCT(curso) FROM cursos WHERE carrera=?";

                            $obj = $pdo -> prepare($sql);

                            $obj -> bindParam(1, $campus, PDO::PARAM_STR, 5);
                            $obj -> execute();
                            
                            while($row = $obj->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<option value='$carrera'>".utf8_encode($carrera)."</option>";
                            } 
                        }
                    ?>
                </select>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-1">
                <label class="form-label">Secci&oacute;n</label>
            </div>
            <div class="col-5">
                <select class="form-select" aria-label="Default select example" name="seccion" id='s3' style="margin-left: 0px; width: 50%;">
                    <option selected>Secci&oacute;n</option>
                    <option value="MO">MO</option>
                    <option value="SM">SM</option>
                    <option value="SI">SI</option>
                    <option value="VI">VI</option>
                </select>
            </div>
            <div class="col-5" style="text-align: center;">
                <button class="btn-primary btn-lg" type="submit" name="grabar" id="grab-btn">GRABAR</button>
            </div>
            
        </div>

                            
       


    </div>

    </body>

</html>