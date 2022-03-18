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

        if(isset($var_post['codalumno'])){
            $codalumno = $var_post['codalumno'];
        } else{
            return;
        }

        if(isset($var_post['retirado'])){
            $retirado = $var_post['retirado'];
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
            // por si no existe el id del curso
                $sqlprev = "SELECT id FROM CURSOS WHERE id = '$id'";

                $sqlprev2 = "SELECT COUNT(codalumno) AS num_alumnos FROM matriculados WHERE id = '$id'";
                $sqlprev3 = "SELECT aforo_covid as maxaforo FROM cursos WHERE id = '$id'";

                $sql = "INSERT INTO matriculados (id, codalumno, retirado) 
                        VALUES ('$id', '$codalumno', '$retirado')";
                
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
                    $json = array("CURSO-NO-EXISTE", "ERROR");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }

                // ejecuta 2 querys
                try{
                    $op = $pdo -> prepare($sqlprev2);
                    $op -> execute();
                } catch(Exception $ex){
                    $json = array("INSERTAR", "ERROR prev");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                while($row = $op -> fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $matric = $num_alumnos;
                }

                // Busca el aforo maximo 
                try{
                    $op = $pdo -> prepare($sqlprev3);
                    $op -> execute();
                } catch(Exception $ex){
                    $json = array("INSERTAR", "ERROR prev");
                    header("Content-Type: application/json");
                    echo json_encode($json);
                    return;
                }
                while($row = $op -> fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $aforomax = $maxaforo;
                }

                // pregunta si se puede matricular un alumno mas
                if($matric < $maxaforo){
                    // se inserta bonito
                    // aqui las cosas salen bien
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
                    //mensaje de que no se puede
                    $json = array("INSERTAR", "ER");
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

