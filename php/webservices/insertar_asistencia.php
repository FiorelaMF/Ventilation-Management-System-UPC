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

        if(isset($var_post['codigo'])){
            $codigo = $var_post['codigo'];
        } else{
            return;
        }

        if(isset($var_post['hora_entrada'])){
            $hora_entrada = $var_post['hora_entrada'];
        } else{
            return;
        }

        if(isset($var_post['hora_salida'])){
            $hora_salida = $var_post['hora_salida'];
        } else{
            return;
        }

        if(isset($var_post['estado'])){
            $estado = $var_post['estado'];
        } else{
            return;
        }

        if(isset($var_post['temperatura'])){
            $temperatura = $var_post['temperatura'];
        } else{
            return;
        }

        if(isset($var_post['key'])){  //encriptacion aes
            $key = $var_post['key'];
        } else{
            return;
        } 

        // Hasta aqui se crearon todas las variables para crear estud

        if($key == "123456"){
            // verifica que el alumno este matriculado
            $sqlprev = "SELECT codalumno FROM matriculados m INNER JOIN programacion p ON m.id = p .id 
                    WHERE m.codalumno = '$codigo' AND p.idsesion = '$idsesion'";
                $estado = utf8_decode($estado);
               

                $sql = "INSERT INTO asistencia (idsesion, codigo, hora_entrada, hora_salida, estado, temperatura) 
                        VALUES ('$idsesion', '$codigo', '$hora_entrada', '$hora_salida', '$estado', '$temperatura')";
                
                try{
                    $op = $pdo -> prepare($sqlprev);
                    $op -> execute();
                    $fil = $op -> fetch(PDO::FETCH_ASSOC);
                } catch(Exception $ex){
                    $json = array("INSERTAR", "ERROR prev");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                if(empty($fil)){
                    $json = array("NOMATRICULADO", "ERROR");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                } else{
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
                }

                
        }  else{
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

