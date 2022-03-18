<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cambiar de Aforo</title>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        
    </head>

    <body>

<?php
    //var_dump($_POST);
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../../index.html");
        return;
    }
    if($_SESSION['admin']!="ADMIN"){
        header("Location:../../../index.html");
        return;
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST); //aula, campus, aforo
        ?>

        <div class="container">
            <br>
            <h2 class="h2 text-center">Cambie el aforo del aula <?php echo $aula ?></h2>
            <br>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Aula</th>
                        <th>Campus</th>
                        <th>Ciclo</th>
                        <th>Aforo</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <form action="querycambiar_aforo.php" method="POST">
                            <tr>
                                <td><?php echo $aula ?><input value=<?php echo $aula ?> name='aula' type='hidden'/></td>
                                <td><?php echo $campus ?><input value=<?php echo $campus ?> name='campus' type='hidden'/></td>
                                <td>2021-2</td>
                                <td><input class="form-control text-center" type="number" name="newaforo" value="<?php echo $aforo ?>"/></td>
                                <td><button class="bt-primary" type="submit">Grabar</button></td>
                            </tr>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>


    <?php
    }

?>

    </body>
</html>
