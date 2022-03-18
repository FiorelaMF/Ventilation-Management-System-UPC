<?php
// WEB SERVICES: POST (crear), GET (leer), PUT (modificar), DELETE(borrar)

    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if(isset($_GET['temperatura'])){
            $temp = $_GET['temperatura'];
        }
        if(isset($temp)){
            $sql = "SELECT codigo, nombre, apellidop, carrera, sexo, campus FROM personal WHERE codigo IN(SELECT codigo FROM asistencia WHERE temperatura>$temp)";
            
            try{
                $qr = $pdo -> prepare($sql);
                $qr -> execute();
                
            } catch(Exception $ex){
                $json = array("Respuesta", "ERROR");
                header("Content-Type: application/json");
                echo json_encode($json);
                return;
            }

            $json = array();
            while($row = $qr -> fetch(PDO::FETCH_ASSOC)){
                extract($row);
                
                $nombre = utf8_decode($nombre); //En caso el nombre tenga tildes
                $apellido = utf8_decode($apellidop);
                $carrera = utf8_decode($carrera);
                $json[] = array("codigo"=>$codigo, "nombres"=>$nombre, "apellido"=>$apellido, "carrera"=>$carrera, "sexo"=>$sexo, "campus"=>$campus);
            }

            header("Content-Type: application/json");
            echo json_encode($json);
            return;
        } else{
            return;

        }
    }

?>