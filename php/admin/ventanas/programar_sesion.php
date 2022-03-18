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
    <div class="container" id="crea_seccion_nueva" style="margin-top:10px;">
        
        <h2 class="h2 text-center">Programar sesi&oacute;n nueva </h2>
        <br>

        <form class="form-group" method="POST">
            <div class="row">
                <div class="col-2"> <label class="form-label"><b>Campus:</b></label> </div>
                <div class="col-4">
                    <select class="form-select" aria-label="Default select example" name="campus6" id='s1' onChange='reload(this.form)' style="margin-left: auto; margin-right: auto; width: 50%;">
                        <option selected>Campus</option>
                        <option value="MO">MO</option>
                        <option value="SM">SM</option>
                        <option value="SI">SI</option>
                        <option value="VI">VI</option>
                    </select>
                </div>
            </div>

        </form>

    </div>

    </body>

</html>
