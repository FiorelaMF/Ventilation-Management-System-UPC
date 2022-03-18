<?php
    header("Content-Type: text/html;charset=utf-8");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST);
        $sql = "UPDATE cursos SET aforo_covid = '$newaforo' WHERE aula='$aula' AND ciclo='2021-2' AND campus='$campus'";
        
        try{
            $obj = $pdo -> prepare($sql);
            $obj -> execute();
        } catch(Exception $ex){
            echo "<script language=javascript> alert('Error al actualizar aforo.');".
                "self.location='../../cerrar.php'</script>"; 
            return;
        }
        echo "<script language=javascript> alert('Se actualiz\u0038 el aforo');".
                "self.location='../menuadmin.php'</script>";
        return;


    }    

?>