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
	header("Content-Type: text/html;charset=utf-8");
	date_default_timezone_set("America/Lima");
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		extract($_POST);
		$sqlprev = "SELECT id FROM cursos WHERE seccion='$seccion'";
		try{
			$obj = $pdo->prepare($sqlprev);
			$obj->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error al ingresar alumno nuevo. Vuelva a intentar...');"."self.location='../../cerrar.php'</script>";
			return;
		}
		$row = $obj->fetch(PDO::FETCH_ASSOC);
		extract($row);
		
		$sqlprev = "SELECT max(idsesion) as ultid FROM programacion";
		try{
			$obj = $pdo->prepare($sqlprev);
			$obj->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error al ingresar alumno nuevo. Vuelva a intentar...');"."self.location='../../cerrar.php'</script>";
			return;
		}
		$row = $obj->fetch(PDO::FETCH_ASSOC);
		extract($row);
		echo $ultid;
		
		if($S1_fecha2==""){
				$sql = "insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+1,'$S1_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+2,'$S2_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+3,'$S3_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+4,'$S4_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+5,'$S5_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+6,'$S6_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+7,'$S7_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+8,'$S8_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+9,'$S9_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+10,'$S10_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+11,'$S11_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+12,'$S12_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+13,'$S13_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+14,'$S14_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+15,'$S15_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+16,'$S16_fecha1','$selectDocente');";
		}
		else{
			$sql = "insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+1,'$S1_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+2,'$S1_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+3,'$S2_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+4,'$S2_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+5,'$S3_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+6,'$S3_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+7,'$S4_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+8,'$S4_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+9,'$S5_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+10,'$S5_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+11,'$S6_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+12,'$S6_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+13,'$S7_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+14,'$S7_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+15,'$S8_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+16,'$S9_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+17,'$S9_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+18,'$S10_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+19,'$S10_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+20,'$S11_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+21,'$S11_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+22,'$S12_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+23,'$S12_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+24,'$S13_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+25,'$S13_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+26,'$S14_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+27,'$S14_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+28,'$S15_fecha1','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+29,'$S15_fecha2','$selectDocente');
				insert into programacion (id, idsesion, fecha, coddocente) values ('$id',$ultid+30,'$S16_fecha1','$selectDocente');
				";
		}
		echo $sql;
		try{
			$obj2 = $pdo->prepare($sql);
			$obj2->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error al ingresar nueva sesion. Vuelva a intentar...');"."self.location='../../cerrar.php'</script>";
			return;
		}
		echo "<script languaje = javascript> alert('Se ingres\u00F3 la nueva sesi\u00F3n.');"."self.location='../admin.php'</script>";
		return;
	}
?>