<?php
// WEB SERVICES: POST (crear), GET (leer), PUT (modificar), DELETE(borrar)

    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Lima");
    $pdo = new PDO('mysql:host=localhost; port=3306; dbname=sotr','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        parse_str(file_get_contents("php://input"), $var_post);
        if(isset($var_post['id'])){
            $id = $var_post['id'];
        } else{
            return;
        }

        if(isset($var_post['codcurso'])){
            $codcurso = $var_post['codcurso'];
        } else{
            return;
        }

        if(isset($var_post['curso'])){
            $curso = $var_post['curso'];
        } else{
            return;
        }

        if(isset($var_post['seccion'])){
            $seccion = $var_post['seccion'];
        } else{
            return;
        }

        if(isset($var_post['campus'])){
            $campus = $var_post['campus'];
        } else{
            return;
        }

        if(isset($var_post['aula'])){
            $aula = $var_post['aula'];
        } else{
            return;
        }

        if(isset($var_post['dia'])){
            $dia = $var_post['dia'];
        } else{
            return;
        }

        if(isset($var_post['hora_inicio'])){
            $hora_inicio = $var_post['hora_inicio'];
        } else{
            return;
        }

        if(isset($var_post['hora_fin'])){
            $hora_fin = $var_post['hora_fin'];
        } else{
            return;
        }

        if(isset($var_post['tipo_sesion'])){
            $tipo_sesion = $var_post['tipo_sesion'];
        } else{
            return;
        }
        
        if(isset($var_post['ciclo'])){
            $ciclo = $var_post['ciclo'];
        } else{
            return;
        }   

        if(isset($var_post['aforo_covid'])){
            $aforo_covid = $var_post['aforo_covid'];
        } else{
            return;
        }

        if(isset($var_post['key'])){  //encriptacion aes
            $key = $var_post['key'];
        } else{
            return;
        } 

        // Hasta aqui se crearon todas las variables para crear el curso

        if($key == "123456"){
            // insertamos el curso
            $h1 = strtotime($hora_inicio); //10:00:00 => 1100000000
            $h2 = strtotime($hora_fin);

            if($h2>$h1){
                // evitar primero que no se ingresen cursos repetidos
                $sqlprev = "SELECT * FROM cursos WHERE codcurso='$codcurso' AND seccion='$seccion' AND ciclo='$ciclo'";

                $sql = "INSERT INTO cursos (id, codcurso, curso, seccion, campus, aula, dia, hora_inicio, hora_fin, tipo_sesion, ciclo, aforo_covid) VALUES ('$id', '$codcurso', '$curso', '$seccion', '$campus', '$aula', '$dia', '$hora_inicio', '$hora_fin', '$tipo_sesion', '$ciclo', '$aforo_covid')";
                
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
                    $json = array("CURSO-EXISTE", "ERROR");
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
            
            } else{
                $json = array("HORAS", "ERROR");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
            }


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

