<div class="col-12" id="matricular_alumno">
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<br><br>
	<h2 class="h2 text-center">Matricular alumno</h2>
	<br>
	<br>
		<form action="querymatricularalumno.php" method="POST">
			<div class="row" align="center">
				<div class="col-12">
					<label for="codcurso">Curso:</label>
					
			<?php
				$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT distinct(curso),codcurso FROM cursos";
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar cursos.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='codcurso' id='codcurso' style='width: 400px;'>";
				echo "<option value='EL212'>An&aacute;lisis de Circuitos El&eacute;ctricos 1</option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value=".$codcurso.">".$curso."</option>";
				}
				echo "</select>";
			?>
				</div>
			</div>
			<br><br>
			<div class="row" align="center">
				<div class="col-12">
					<label for="seccion">Secci&oacute;n:</label>
					
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					extract($_POST);
					$sql = "SELECT seccion FROM cursos WHERE codcurso='$codcurso'";
				}
				else{
					$sql = "SELECT seccion FROM cursos order by seccion";
				}
				$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar secciones.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='seccion' id='seccion' style='width: 400px;'>";
				echo "<option value='noseccion'>Seleccionar Secci&oacute;n</option>";
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value=".$seccion.">".$seccion."</option>";
				}
				echo "</select>";
			?>
				</div>
			</div>
			<br><br>
			<div class="row" align="center">
				<div class="col-12">
					<label for="codigo">C&oacute;digo Alumno:</label>
					<input type="text" name="codigo" style='width: 250px;'/>
				</div>
			</div>
			<br><br>
			<div class="row" align="center">
				<div class="col-6">
					<button class="btn btn-primary" type="submit" style="width: 200px;margin-right: auto; margin-left: auto;" name="accion" value="matricular">Matricular</button>
				</div>
				<div class="col-6">
					<button class="btn btn-primary" type="submit" style="width: 200px;margin-right: auto; margin-left: auto;" name="accion" value="retirar">Retirar</button>
				</div>
			</div>
		</form>
</div>