<?php
// WEB SERVICES: POST (crear), GET (leer), PUT (modificar), DELETE(borrar)

    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        parse_str(file_get_contents("php://input"), $var_post);
        if(isset($var_post['idsesion'])){
            $idsesion = $var_post['idsesion'];
        } else{
            return;
        }

        if(isset($var_post['CO2aula'])){
            $CO2aula = $var_post['CO2aula'];
        } else{
            return;
        }

        if(isset($var_post['CO2externo'])){
            $CO2externo = $var_post['CO2externo'];
        } else{
            return;
        }

        if(isset($var_post['aforo'])){
            $aforo = $var_post['aforo'];
        } else{
            return;
        }

        if(isset($var_post['fecha'])){
            $fecha = $var_post['fecha'];
        } else{
            return;
        }

        if(isset($var_post['hora'])){
            $hora = $var_post['hora'];
        } else{
            return;
        }

        if(isset($var_post['key'])){  //encriptacion aes
            $key = $var_post['key'];
        } else{
            return;
        } 

        if($key == "123456"){
            // verifica que el alumno este matriculado
            $sqlprev = "SELECT c.hora_inicio, c.hora_fin FROM cursos c 
                            INNER JOIN programacion p ON c.id = p .id WHERE p.idsesion = '$idsesion'";

                $sql = "INSERT INTO ventilacion (idsesion, CO2aula, CO2externo,	aforo, fecha, hora) 
                        VALUES ('$idsesion', '$CO2aula', '$CO2externo', '$aforo', '$fecha', '$hora')";
                
                try{
                    $op = $pdo -> prepare($sqlprev);
                    $op -> execute();
                } catch(Exception $ex){
                    $json = array("INSERTAR", "ERROR prev");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                while($fil = $op -> fetch(PDO::FETCH_ASSOC)){
                    extract($fil);
                    $hini = $hora_inicio;
                    $hfin = $hora_fin;
                } 
                
                if(strtotime($hora) >= strtotime($hini) && strtotime($hora) <= strtotime($hfin) ){
                    // se insertan los datos
                    try{
                        $obj = $pdo -> prepare($sql);
                        $obj -> execute();
                    } catch(Exception $ex){
                        $json = array("INSERTAR", "ERROR");
                        echo $sql;
                        header("Content-Type: application/json");
                        echo json_encode($json);
                        return;
                    }

                    $json = array("INSERTAR", "OK");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;

                } else{
                    $json = array("INSERTAR", "ER");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                
                

                
        } else{
            $json = array("BAD", "KEY");
            header("Content-Type: application/json");
            echo json_encode($json);
            return;
        }


    } else{
        $json = array("NO", "GET");
        header("Content-Type: application/json");
        json_encode($json);
        return;
    }







    
    
?>

