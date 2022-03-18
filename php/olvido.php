<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Ventilaci&oacute;n UPC</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        

    </head>

    <style>
        body{   
            background-image: url("../img/fondo_rombo.png");
        }
        #enviar{
            background-color: rgb(92, 87, 88);
            font-family: 'Trebuchet MS';
            border-color: rgb(150, 140, 142);
        }
    </style>


    <body>
        <br><br>
        <div class="container">
            <form class="form-group" method="POST">
                <img class="mb-4" src="../img/UPC_logo_transparente.png" width="80px" height="auto">
                <br>
                <h3 class="h4 mb-3 font-weight-normal">Ingrese su c&oacute;digo de estudiante o docente:</h3>
                <input type="text" class="form-control" name="codigo">
                <br><br>
                <button class="btn-primary btn-lg" type="submit" id="enviar">Enviar</button>
            </form>

        <?php
            // verificar que no este vacio
            if(isset($_POST['enviar'])){
                if(!empty($_POST['codigo'])){
                    $codigo = $_POST['codigo'];

                    // Validar que el codigo este en la BD



                    // Enviar correo OJO solo funciona si esta subido a un webhost
                    $correo = $codigo . "@upc.edu.pe";
                    $asunto = "Cambio de contraseña - UPC";
                    $msg = "Para cambiar su contraseña, siga los siguientes pasos:";

                    $header = "From: noreply@example.com" . "\r\n";
                    $header .= "Reply-To: noreply@example.com" . "\r\n";
                    $header .= "X-Mailer: PHP/". phpversion();
                    $mail = @mail($correo,$asunto,$msg,$header);
                    if($mail){
                        echo "<br><h3>Correo enviado. Revise su bandeja de spam.</h3>";
                        echo "<script>alert('Correo enviado. Revise su bandeja de spam.')</script>";
                    }   
                }
            }

        ?>

    </body>
</html>