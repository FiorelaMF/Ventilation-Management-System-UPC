<?php
// WEB SERVICES: POST (crear), GET (leer), PUT (modificar), DELETE(borrar)

    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        parse_str(file_get_contents("php://input"), $var_post);
        if(isset($var_post['codigo'])){
            $codigo = $var_post['codigo'];
        } else{
            return;
        }

        if(isset($var_post['nombre'])){
            $nombre = $var_post['nombre'];
        } else{
            return;
        }

        if(isset($var_post['apellidop'])){
            $apellidop = $var_post['apellidop'];
        } else{
            return;
        }

        if(isset($var_post['apellidom'])){
            $apellidom = $var_post['apellidom'];
        } else{
            return;
        }

        if(isset($var_post['carrera'])){
            $carrera = $var_post['carrera'];
        } else{
            return;
        }

        if(isset($var_post['sexo'])){
            $sexo = $var_post['sexo'];
        } else{
            return;
        }

        if(isset($var_post['campus'])){
            $campus = $var_post['campus'];
        } else{
            return;
        }

        if(isset($var_post['estado'])){
            $estado = $var_post['estado'];
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
            // insertamos el estud
            // verifica que no haya codigo repetido
                $sqlprev = "SELECT codigo FROM personal WHERE estado = 'ALUMNO' AND codigo = '$codigo'";

                $nombre = utf8_decode($nombre);
                $apellidop = utf8_decode($apellidop);
                $apellidom = utf8_decode($apellidom);
                $carrera = utf8_decode($carrera);

                $sql = "INSERT INTO personal (codigo, nombre, apellidop, apellidom, carrera, sexo, campus, estado) 
                        VALUES ('$codigo', '$nombre', '$apellidop', '$apellidom', '$carrera', '$sexo', '$campus', '$estado')";
                
                try{
                    $op = $pdo -> prepare($sqlprev);
                    $op -> execute();
                } catch(Exception $ex){
                    $json = array("INSERTAR", "ERROR prev");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                if($fil = $op -> fetch(PDO::FETCH_ASSOC)){
                    $json = array("CODIGO-EXISTE", "ERROR");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }

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
        
        $json = array("BAD", "KEY");
        header("Content-Type: application/json");
        echo json_encode($json);
        return;

    } else{
        $json = array("NO", "GET");
        header("Content-Type: application/json");
        json_encode($json);
        return;
    }
?>

