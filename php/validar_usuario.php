<?php

    date_default_timezone_set("America/Lima");
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST);  // genera variables $usuario y $clave

        //no cambiar esta parte
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr', 'root', '');
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM usuarios WHERE codigo=:codigo AND clave=".
                "aes_encrypt(:password, 'upc')";

        // Ejecucion del query SQL desde PHP
        try{
            $con = $pdo -> prepare($sql);
            $con -> execute(array(
                                    ':codigo' => $usuario,
                                    ':password' => $clave));

            //echo $usuario;
            //echo $clave;
        }catch(Exception $ex){
            header('Location:../index.html'); //te manda al index si hay un error
            echo "<script>alert('Usuario o contraseña incorrectos')</script>";
            return;
        }

        // Hasta este punto, significa que no hubo error en la ejecucion
        // Se lee el primer registro devuelto por el query SQL (fetch -> cargar)
        if($row = $con -> fetch(PDO::FETCH_ASSOC)){
            $sql = "SELECT estado FROM personal WHERE codigo = '$usuario'";
            //echo $sql;
            //$sql = "SELECT estado FROM usuarios WHERE codigo = '$usuario'";

                try{
                    $con2 = $pdo -> prepare($sql);
                    $con2 -> execute();
                } catch(Exception $ex){
                    header('Location:../index.html'); //te manda al index si hay un error
                    return;
                }

                $fila = $con2 -> fetch(PDO::FETCH_ASSOC);
                $admin = $fila['estado'];

                //Como se ha ingresado al sistema, se aumenta el veces
                $accesos = $row['veces']+1;
                $sql2 = "UPDATE usuarios SET veces=$accesos WHERE codigo='$usuario'";

                // try 2
                try{
                    $con3 = $pdo -> prepare($sql2);
                    $con3 -> execute();
                } catch(Exception $ex){   // SE QUEDA ACA
                    header('Location:../index.html'); //te manda al index si hay un error
                    return;
                    //echo $sql2;
                }
                
            // --------------- Iniciar una sesion ---------------
            session_start();
            //pasar variables
            $_SESSION['usuario'] = $usuario;
            $_SESSION['admin'] = $admin;
            $_SESSION['hora_ingreso'] = date("Y-n-j H:i:s");
            if($admin=='ADMIN'){
                header("Location:admin/menuadmin.php");
                return;
            } 
            else if($admin=="DOCENTE"){
                header("Location:docente/menudocente.php");
                return;
            }
            else if($admin == "ALUMNO"){
                header("Location:alumno/menualumno.php");
                return;
            }
            else{
                echo "<script language=javascript".
                "self.location='../index.html'</script>";
            }

        } else{
            echo "<script language=javascript>".
                    "alert('Usuario o clave equivocados. Por favor vuelve a ingresar tus datos.');".
                    "self.location='../index.html'</script>";

            
        }


    }else{
        echo "<script language=javascript>".
                "self.location='../index.html'</script>";
    }

    

?>