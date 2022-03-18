<div class="col-12" id="programar_sesiones">
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<a id="menu" href="../menuadmin.php" style="margin-top:10px; margin-left: 20px;">Men&uacute; Principal</a>
	<br><br>
	<h2 class="h2 text-center">Programar Sesiones</h2>
	<br>
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
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		extract($_POST);
	}
?>
	<div class="container">
		<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th>Carrera</th>
						<th>Campus</th>
						<th>Curso</th>
						<th>Secci&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<form action = "programarsesiones.php" method = "POST">
						<tr>
						
			<?php
				$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				
				$sql = "SELECT distinct(carrera) FROM personal";
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar carrera.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<td><select name='selectCarrera' id='selectCarrera' onchange='this.form.submit()'>";
				if(isset($selectCarrera)){
					echo "<option value='".$selectCarrera."'>".$selectCarrera."</option>";				
				}
				echo "<option value=''></option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 	
					echo "<option value='".$carrera."'>".$carrera."</option>";
				}
				echo "</select></td>";
				
				if(isset($selectCarrera) and $selectCarrera !=""){
					$sql = "SELECT distinct(campus) FROM personal WHERE carrera='$selectCarrera'";
				}
				else{
					$sql = "SELECT distinct(campus) FROM personal";
				}
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar campus.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<td><select name='selectCampus' id='selectCampus' onchange='this.form.submit()'>";
				if(isset($selectCampus)){
					echo "<option value='".$selectCampus."'>".$selectCampus."</option>";				
				}
				echo "<option value=''></option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 	
					echo "<option value='".$campus."'>".$campus."</option>";
				}
				echo "</select></td>";
				
				if(isset($selectCarrera) and $selectCarrera !=""){
					if(isset($selectCampus)  and $selectCampus !=""){
						$sql = "SELECT distinct(cursos.curso) FROM ((programacion INNER JOIN cursos ON programacion.id=cursos.id) INNER JOIN personal ON programacion.coddocente=personal.codigo) WHERE personal.carrera='$selectCarrera' and  personal.campus='$selectCampus'";
					}
					else{
						$sql = "SELECT distinct(cursos.curso) FROM ((programacion INNER JOIN cursos ON programacion.id=cursos.id) INNER JOIN personal ON programacion.coddocente=personal.codigo) WHERE personal.carrera='$selectCarrera'";
					}
				}
				else{
					if(isset($selectCampus)  and $selectCampus !=""){
						$sql = "SELECT distinct(curso) FROM cursos WHERE campus='$selectCampus'";
					}
					else{
						$sql = "SELECT distinct(curso) FROM cursos";
					}
				}
				//echo $sql;
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar codigos de cursos.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<td><select name='selectCurso' id='selectCurso' onchange='this.form.submit()'>";
				if(isset($selectCurso)){
					echo "<option value='".$selectCurso."'>".$selectCurso."</option>";				
				}
				echo "<option value=''></option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 	
					echo "<option value='".$curso."'>".$curso."</option>";
				}
				echo "</select></td>";
								
				if(isset($selectCurso) and $selectCurso !=""){
					$sql = "SELECT seccion FROM cursos WHERE curso='$selectCurso'";
				}
				else{
					$sql = "SELECT seccion FROM cursos order by seccion";
				}			
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar seccion.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<td><select name='selectSeccion' id='selectSeccion' onchange='this.form.submit()'>";
				if(isset($selectSeccion)){
					echo "<option value=".$selectSeccion.">".$selectSeccion."</option>";				
				}
				echo "<option value=''></option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 	
					echo "<option value='".$seccion."'>".$seccion."</option>";
				}
				echo "</select></td>";				
				echo "</tr>";
			echo "</form>";
		echo "</tr>";
	echo "</tbody>";
echo "</table>";
?>
<br>
	<h4 class="h4" style="width: 95%;margin-right: auto; margin-left: auto;">Ingresar Sesiones:</h4>
	<table class="table table-bordered text-center" style="width: 95%;margin-right: auto; margin-left: auto;">
		<thead>
			<th>Semana de Ciclo</th>
			<th>Fecha Primera Sesi&oacute;n</th>
			<th>Fecha Segunda Sesi&oacute;n</th>
		</thead>
		<tbody>
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					extract($_POST); 
					$S1_fecha1 = ""; $S1_fecha2 = ""; $S2_fecha1 = ""; $S2_fecha2 = ""; $S3_fecha1 = ""; $S3_fecha2 = ""; $S4_fecha1 = ""; $S4_fecha2 = ""; $S5_fecha1 = ""; $S5_fecha2 = ""; $S6_fecha1 = ""; $S6_fecha2 = ""; $S7_fecha1 = ""; $S7_fecha2 = ""; $S8_fecha1 = ""; $S9_fecha1 = ""; $S9_fecha2 = ""; $S10_fecha1 = ""; $S10_fecha2 = ""; $S11_fecha1 = ""; $S11_fecha2 = ""; $S12_fecha1 = ""; $S12_fecha2 = ""; $S13_fecha1 = ""; $S13_fecha2 = ""; $S14_fecha1 = ""; $S14_fecha2 = ""; $S15_fecha1 = ""; $S15_fecha2 = ""; $S16_fecha1 = "";
					
					echo "<form action = 'query_programar_sesion.php' method = 'POST'>";
					
					echo "<tr><td>S1</td>";
					echo "<td><input class='form-control text-center' type='date' name='S1_fecha1' value='".$S1_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S1_fecha2' value=".$S1_fecha2."></td></tr>";
					
					echo "<tr><td>S2</td>";
					echo "<td><input class='form-control text-center' type='date' name='S2_fecha1' value='".$S2_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S2_fecha2' value=".$S2_fecha2."></td></tr>";
					
					echo "<tr><td>S3</td>";
					echo "<td><input class='form-control text-center' type='date' name='S3_fecha1' value='".$S3_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S3_fecha2' value=".$S3_fecha2."></td></tr>";
					
					echo "<tr><td>S4</td>";
					echo "<td><input class='form-control text-center' type='date' name='S4_fecha1' value='".$S4_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S4_fecha2' value=".$S4_fecha2."></td></tr>";
					
					echo "<tr><td>S5</td>";
					echo "<td><input class='form-control text-center' type='date' name='S5_fecha1' value='".$S5_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S5_fecha2' value=".$S5_fecha2."></td></tr>";
					
					echo "<tr><td>S6</td>";
					echo "<td><input class='form-control text-center' type='date' name='S6_fecha1' value='".$S6_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S6_fecha2' value=".$S6_fecha2."></td></tr>";
					
					echo "<tr><td>S7</td>";
					echo "<td><input class='form-control text-center' type='date' name='S7_fecha1' value='".$S7_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S7_fecha2' value=".$S7_fecha2."></td></tr>";
					
					echo "<tr><td>S8 - Ex. Parcial</td>";
					echo "<td><input class='form-control text-center' type='date' name='S8_fecha1' value='".$S8_fecha1."'></td>";
					echo "<td> - </tr>";
					
					echo "<tr><td>S9</td>";
					echo "<td><input class='form-control text-center' type='date' name='S9_fecha1' value='".$S9_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S9_fecha2' value=".$S9_fecha2."></td></tr>";
					
					echo "<tr><td>S10</td>";
					echo "<td><input class='form-control text-center' type='date' name='S10_fecha1' value='".$S10_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S10_fecha2' value=".$S10_fecha2."></td></tr>";
					
					echo "<tr><td>S11</td>";
					echo "<td><input class='form-control text-center' type='date' name='S11_fecha1' value='".$S11_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S11_fecha2' value=".$S11_fecha2."></td></tr>";
					
					echo "<tr><td>S12</td>";
					echo "<td><input class='form-control text-center' type='date' name='S12_fecha1' value='".$S12_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S12_fecha2' value=".$S12_fecha2."></td></tr>";
					
					echo "<tr><td>S13</td>";
					echo "<td><input class='form-control text-center' type='date' name='S13_fecha1' value='".$S13_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S13_fecha2' value=".$S13_fecha2."></td></tr>";
					
					echo "<tr><td>S14</td>";
					echo "<td><input class='form-control text-center' type='date' name='S14_fecha1' value='".$S14_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S14_fecha2' value=".$S14_fecha2."></td></tr>";
					
					echo "<tr><td>S15</td>";
					echo "<td><input class='form-control text-center' type='date' name='S15_fecha1' value='".$S15_fecha1."'></td>";
					echo "<td><input class='form-control text-center' type='date' name='S15_fecha2' value=".$S15_fecha2."></td></tr>";
					
					echo "<tr><td>S16 - Ex. Final</td>";
					echo "<td><input class='form-control text-center' type='date' name='S16_fecha1' value='".$S16_fecha1."'></td>";
					echo "<td> - </td></tr>";
					
					echo "</tr><td>C&oacute;digo Docente:</td>";
					if(isset($selectCarrera)  and $selectCarrera !=""){
						if(isset($selectCampus)  and $selectCampus !=""){
							$sql = "SELECT codigo FROM personal WHERE carrera='$selectCarrera' and campus='$selectCampus' and estado='DOCENTE'";	
						}
						else{
							$sql = "SELECT codigo FROM personal WHERE carrera='$selectCarrera' and estado='DOCENTE'";
						}
					}	
					else{
						if(isset($selectCampus)  and $selectCampus !=""){
							$sql = "SELECT codigo FROM personal WHERE campus='$selectCampus' and estado='DOCENTE'";	
						}
						else{
							$sql = "SELECT codigo FROM personal WHERE estado='DOCENTE'";
						}
					}	
					try{
						$obj = $pdo->prepare($sql);
						$obj->execute();
					}catch(Exception $ex){
						echo "<script languaje = javascript> alert('Error al selecionar seccion.');"."self.location='../../cerrar.php'</script>";
						return;
					}
					echo "<td><select name='selectDocente' id='selectDocente' style='width: 90%'>";
					if(isset($selectDocente)){
						echo "<option value=".$selectDocente.">".$selectDocente."</option>";				
					}
					echo "<option value=''></option>";
					while($row = $obj->fetch(PDO::FETCH_ASSOC)){
						extract($row); 	
						echo "<option value='".$codigo."'>".$codigo."</option>";
					}
					echo "</td>";
					echo "<td><button class='btn-primary' type='submit' style='width: 80%'>Grabar</button><input name='seccion' value='$selectSeccion' type='hidden'/>";
					echo "</tr></form>";
				}
			?>
		</tbody>
	</table>
</div>