<?php
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../index.html");
        return;
    }
    if($_SESSION['admin']!="ALUMNO"){
        header("Location:../../index.html");
        return;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cambio de contrase&ntilde;a</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
        *{
            margin-top: 0px:
        }
        body{   
            background-image: url("../../../img/fondo_rombo.png");
        }
        label{
            color: white;
            text-decoration: bold;
            margin-left: 10px;
            margin-right: 10px;
        }
        h4{
            color: white;
            text-decoration: bold;
            margin-left: 10px;
            margin-right: 10px;
        }
        h2{
            font-family: 'Verdana';
            font-size: 30px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        img{
            text-align: center;
            height: 140px;
            width: auto;
        }
        input{
            margin-left: 25px;
        }
        #contenedor{
            background-color: #e11818;
            border-color: darkred;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
        }
        .container{
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        #btn_enviar{
            background-color: lightgray;
            border-color: darkgray;
            alignment: center;
            color: black;
            margin-bottom: 10px;
        }
        
</style>

<body>
        <br><br>
        <div class="container">
            <form class="form-group" method="POST">
                <img class="mb-4" src="../../../img/UPC_logo_transparente.png">
                <h2 class="form-signin-heading">Cambio de contrase&ntilde;a</h2>

                <div id="contenedor">
                <br>
                <h4 class="h4 mb-3 font-weight-normal">Para cambiar su contraseña, primero ingrese sus datos:</h4>
                
                <label class="form-label">C&oacute;digo:</label>
                <input type="text" class="form-control" name="codigo" style="width: 90%;"/>

                <br>
                <label class="form-label">Contrase&ntilde;a anterior:</label>
                <input type="password" class="form-control" name="clave_ant" style="width: 90%;"/>

                <br>
                <label class="form-label">Contrase&ntilde;a nueva:</label>
                <input type="password" class="form-control" name="clave_nueva" style="width: 90%;"/>

                <br>
                <button class="btn-primary btn-lg" type="submit" id="btn_enviar"><b>Enviar<b></button>
                </div>

                
                <p class="mt-5 mb-3 text-muted">&copy; UPC-Electr&oacute;nica 2021-2</p>
            </form>
        </div>

        <?php

            function validar_contra($contrasena){
                if(strlen($contrasena) >= 6){
                    return True;
                } else{ return False;}
            }
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $codigo = $_POST['codigo'];
                $clave_ant = $_POST['clave_ant'];
                $clave_nueva = $_POST['clave_nueva'];
                $sql = "SELECT codigo, AES_DECRYPT(clave, 'upc') AS clave_decod FROM `usuarios` WHERE codigo = '$codigo'";

                $pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr', 'root', '');
                $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Ejecucion del query SQL desde PHP
                try{
                    $con = $pdo -> prepare($sql);
                    $con -> execute();

                }catch(Exception $ex){
                    header('Location:../menudocente.html'); //te manda al index si hay un error
                    return;
                }

                if(validar_contra($clave_nueva) == True){
                    while($row = $con->fetch(PDO::FETCH_ASSOC)){
                        extract($row); 
                        if($clave_ant == $clave_decod){
                            // las contrrasenas coinciden, procede a cambiar la contrasena
                            $sql_cambio = "UPDATE usuarios SET clave = AES_ENCRYPT('$clave_nueva','upc') WHERE codigo = '$codigo'";
                            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr', 'root', '');
                            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Ejecucion del query SQL desde PHP
                            try{
                                $con2 = $pdo -> prepare($sql_cambio);
                                $con2 -> execute();
                                echo "<script language=javascript>alert('Se cambió la contraseña correctamente.')</script>";
                            }catch(Exception $ex){
                                echo "<script language=javascript>alert('Error en cambio de contraseña.')</script>";
                                return;
                            }
                
                            
                        } else{
                            // manda un alert de datos incorrectos
                            echo "<script language=javascript>alert('Usuario o contraseña incorrectos. Vuelva a intentarlo.')</script>";
                        }
    
                    }
                } else{
                    echo "<script language=javascript>alert('Nueva contraseña no válida. Verificar que la nueva contraseña tenga por lo menos 6 caracteres.')</script>";
                }

                

            }
        ?>
        
        
</body>
</html>