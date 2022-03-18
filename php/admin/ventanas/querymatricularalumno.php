<?php
	/*Por seguridad debo evaluar si el ingreso a menú admin es por sesión*/
	session_start();
	if(!isset($_SESSION['usuario'])|| !isset($_SESSION['admin'])){
		header("Location:../../../index.html");
		return;
	}
	if($_SESSION['admin']!="ADMIN"){
		header("Location:../../../index.html");
		return;
	}
	
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		extract($_POST);
		$prepresql = "select id, aforo_covid from cursos where codcurso='$codcurso' and seccion='$seccion'";
		try{
			$obj = $pdo->prepare($prepresql);
			$obj->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error curso o seccion no existe.');"."self.location='../menu_admin.php'</script>";
			return;
		}		
		$row = $obj->fetch(PDO::FETCH_ASSOC);
		extract($row);
		// Se tiene id
		if ($_POST['accion'] == 'matricular') {
			$presql = "select count(codalumno) as matricul from matriculados where id='$id'";
			try{
				$obj2 = $pdo->prepare($presql);
				$obj2->execute();
			}catch(Exception $ex){
				echo "<script languaje = javascript> alert('Error evaluando aforo.');"."self.location='../menu_admin.php'</script>";
				return;
			}
			$row2 = $obj2->fetch(PDO::FETCH_ASSOC);
			extract($row2);
			if($matricul >= $aforo_covid){
				//echo "<script languaje = javascript> alert('Aforo no pertime matricula.');"."self.location='../menu_admin.php'</script>";
				//return;
			}
			//Aforo permite matricula
			$sql = "insert into matriculados (id, codalumno) value ('$id', '$codigo')";
			try{
				$obj = $pdo->prepare($sql);
				$obj->execute();
			}catch(Exception $ex){
				echo "<script languaje = javascript> alert('Error no se logr\u00F3 matricular alumno.');"."self.location='../menu_admin.php'</script>";
				return;
			}
			echo "<script languaje = javascript> alert('Se matricul\u00F3 alumno.');"."self.location='../menu_admin.php'</script>";
		} else if ($_POST['accion'] == 'retirar') {
			$presql = "select * from matriculados where id='$id' and codalumno='$codigo'";
			try{
				$obj = $pdo->prepare($presql);
				$obj->execute();
			}catch(Exception $ex){
				echo "<script languaje = javascript> alert('Error alumno no matriculado.');"."self.location='../menu_admin.php'</script>";
				return;
			}
			$sql = "delete from matriculados where id='$id' and codalumno='$codigo'";
			try{
				$obj = $pdo->prepare($sql);
				$obj->execute();
			}catch(Exception $ex){
				echo "<script languaje = javascript> alert('Error al retirar alumno.');"."self.location='../menu_admin.php'</script>";
				return;
			}
			echo "<script languaje = javascript> alert('Se retir\u00F3 alumno.');"."self.location='../menu_admin.php'</script>";
		} else {
			echo "<script languaje = javascript> alert('Error.');"."self.location='../../cerrar.php'</script>";
		}
		return;
	}
?>