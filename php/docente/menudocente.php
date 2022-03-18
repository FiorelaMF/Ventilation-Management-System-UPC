<?php
    /*SEGURIDAD: evaluar si el ingreso a menu admin es por sesión */
    session_start();
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])){
        header("Location:../../index.html");
        return;
    }
    if($_SESSION['admin']!="DOCENTE"){
        header("Location:../../index.html");
        return;
    }

    $usuario = $_SESSION['usuario'];
    $admin = $_SESSION['admin'];

    $sql = "SELECT nombre, apellidop FROM personal WHERE codigo = '$usuario'";
    $nombre = "";
    $apellido = "";
    
    //no cambiar esta parte
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr', 'root', '');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejecucion del query SQL desde PHP
    try{
        $con = $pdo -> prepare($sql);
        $con -> execute();

    }catch(Exception $ex){
        header('Location:../index.html'); //te manda al index si hay un error
        return;
    }

    if($row = $con -> fetch(PDO::FETCH_ASSOC)){
        $nombre = $row['nombre'];
        $apellido = $row['apellidop'];
    }

    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido'] = $apellido;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MENU DOCENTE</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Gesti&oacute;n de ventilaci&oacute;n UPC</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Mis clases</a>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" id="ver_misasist">Ver mis asistencias</a></li>
        <li><a class="dropdown-item" href="#" id="ver_asistcursos">Ver asistencias de mis cursos</a></li>
        <li><a class="dropdown-item" href="#" id="ver_ventilacion">Ver ventilaci&oacute;n de aulas</a></li>
        </ul>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="ventanas/cambioPassword.php">Cambiar contrase&ntilde;a</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">Bienvenido/a <?php echo $nombre." ".$apellido ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../cerrar.php">Cerrar Sesi&oacute;n</a>
    </li>
    </ul>

    <div class="jumbotron" id="bienvenida">
        <div class="container">
            <h1 class="display-3">Bienvenidos/as al sistema de gesti&oacute;n de ventilaci&oacute;n de la UPC</h1>
        </div>
    </div>
    <script language=javascript> $("#bienvenida").show();
        $("#ver_mis_asist").hide();
        $("#ver_asist_curs").hide();
        $("#ver_vent_doc").hide();</script>
    <?php
        include 'ventanas/verMisAsist.php';
        include 'ventanas/verAsistCursos.php';
        include 'ventanas/verVentilacion.php';
    ?>

<script type="text/JavaScript" src="../../js/controlador_docente.js"></script>
<?php
    if($estado1==0 && $estado2==0 && $estado3==0){
        echo "<script languaje=javascript> $('#bienvenida').show();".
        "$('#ver_mis_asist').hide();".
        "$('#ver_asist_curs').hide();".
        "$('#ver_vent_doc').hide(); </script>";
    } else if($estado1==1){
        echo "<script languaje=javascript> $('#bienvenida').hide();".
        "$('#ver_asist_curs').hide();".
        "$('#ver_vent_doc').hide();".
        "$('#ver_mis_asist').fadeIn(2000); </script>";
    } else if($estado2==1){
        echo "<script languaje=javascript> $('#bienvenida').hide();".
        "$('#ver_mis_asist').hide();".
        "$('#ver_vent_doc').hide();".
        "$('#ver_asist_curs').fadeIn(2000); </script>";

    } else if($estado3==1){
        echo "<script languaje=javascript> $('#bienvenida').hide();".
        "$('#ver_mis_asist').hide();".
        "$('#ver_asist_curs').hide();".
        "$('#ver_vent_doc').fadeIn(1000); </script>";
    }
?>

</body>

</html>