<div class="col-12" id="ver_ventilacion">
	<meta charset="utf-8">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<a id="menu" href="../menuadmin.php" style="margin-top:10px; margin-left: 20px;">Men&uacute; Principal</a>
	<br><br>
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
	?>
	<h2 class="h2 text-center">Ver Asistencia</h2>
	<br>
		<form action="ver_asistencia.php" method="POST">
			<div class="row" align="center">
				<div class="col-3">
					
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					extract($_POST); 
				}
				header("Content-Type: text/html;charset=utf-8");
				date_default_timezone_set("America/Lima");
				$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				echo "<label for='carreraSelect'>Carrera:</label>";
				$sql = "SELECT distinct(carrera) FROM personal order by carrera";
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar curso.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='carreraSelect' id='carreraSelect' style='width: 180px'>";
				if ($carreraSelect == "" or $carreraSelect == "nocarrera"){
					echo "<option value='nocarrera'>Seleccionar Carrera</option>";
					$carreraSelect = "";
				}
				else{
					echo "<option value=".$carreraSelect.">".$carreraSelect."</option>";
					echo "<option value='nocarrera'>Seleccionar Carrera</option>";
				}
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value='".$carrera."'>".$carrera."</option>";
				}
				echo "</select>";
				echo "</div>";
				echo "<div class='col-3'>";
				echo "<label for='cursoSelect'>Curso:</label>";
				$sql = "SELECT distinct(curso), codcurso FROM cursos";
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar curso.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='cursoSelect' id='cursoSelect' style='width: 180px'>";
				if ($cursoSelect == "" or $cursoSelect == "nocurso"){
					echo "<option value='nocurso'>Seleccionar Curso</option>";
					$cursoSelect = "";
				}
				else{
					echo "<option value='".$cursoSelect."'>".$cursoSelect."</option>";
					echo "<option value='nocurso'>Seleccionar Curso</option>";
				}
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value='".$curso."'>".$curso." (".$codcurso.")</option>";
				}
				echo "</select>";
				echo "</div>";
				echo "<div class='col-3'>";
				echo "<label for='campusSelect'>Campus:</label>";
				if ($cursoSelect == "" or $cursoSelect == "nocurso"){
					$sql = "SELECT distinct(campus) FROM cursos";
				}
				else{
					$sql = "SELECT distinct(campus) FROM cursos WHERE curso='$cursoSelect'";
				}
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar campus.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='campusSelect' id='campusSelect' style='width: 180px'>";
				if ($campusSelect == "" or $campusSelect == "nocampus"){
					echo "<option value='nocampus'>Seleccionar Campus</option>";
					$campusSelect = "";
				}
				else{
					echo "<option value=".$campusSelect.">".$campusSelect."</option>";
					echo "<option value='nocampus'>Seleccionar Campus</option>";
				}
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value=".$campus.">".$campus."</option>";
				}
				echo "</select>";
				echo "</div>";
				echo "<div class='col-3'>";
				echo "<label for='aulaSelect'>Aula: </label>";
				if (($campusSelect == "" or $campusSelect == "nocampus")and($cursoSelect == "" or $cursoSelect == "nocurso")){
					$sql = "SELECT distinct(aula) FROM cursos";
				}
				else if ($cursoSelect == "" or $cursoSelect == "nocurso"){
					$sql = "SELECT distinct(aula) FROM cursos WHERE campus='$campusSelect'";
				}
				else if ($campusSelect == "" or $campusSelect == "nocampus"){
					$sql = "SELECT distinct(aula) FROM cursos WHERE curso='$cursoSelect'";
				}
				else{
					$sql = "SELECT distinct(aula) FROM cursos WHERE curso='$cursoSelect' and campus='$campusSelect'";
				}
				//echo $sql;
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al selecionar cursos.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				echo "<select name='aulaSelect' id='aulaSelect' style='width: 180px'>";
				if ($aulaSelect == "" or $aulaSelect == "noaula"){
					echo "<option value='noaula'>Seleccionar Aula</option>";
					$aulaSelect = "";
				}
				else{
					echo "<option value=".$aulaSelect.">".$aulaSelect."</option>";
					echo "<option value='noaula'>Seleccionar Aula</option>";
				}
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					echo "<option value=".$aula.">".$aula."</option>";
				}
				echo "</select>";
			?>
				</div>
			</div>
			<br>
			<div class="row" align="center">
				<div class="col-12">
					<button id="vergraf" class="btn btn-primary" type="submit" style="width: 120px;margin-right: auto; margin-left: auto;">Graficar</button>
				</div>
			</div>
		</form>
		<br>		
		<h1 class="h1 text-center"> Gr&aacute;fica de Asistencia</h1>
		
<?php
	/*Por seguridad debo evaluar si el ingreso a menú admin es por sesión*/
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		extract($_POST);
		$presql = "select id, aforo_covid from cursos where curso='$cursoSelect' and campus='$campusSelect' and aula='$aulaSelect'";
		//echo $presql;
		try{
			$obj = $pdo->prepare($presql);
			$obj->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error curso no existe.');"."self.location='../menuadmin.php'</script>";
			return;
		}	
		$row = $obj->fetch(PDO::FETCH_ASSOC);
		$aforo_covid = $row['aforo_covid'];
		$id = $row['id'];
		//echo "id:".$id;
		$sql = "select distinct(fecha) from programacion where id='$id'";
		//echo $sql;
		try{
			$obj = $pdo->prepare($sql);
			$obj->execute();
		}catch(Exception $ex){
			echo "<script languaje = javascript> alert('Error sesion no existe.');"."self.location='../menuadmin.php'</script>";
			return;
		}	
		$aforo_aula = [];
		$fechas = [];		
		$aforo_covid_aula = [];
		while($row = $obj->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$sql2 = "select max(ventilacion.aforo) as aforoMax from ventilacion INNER JOIN programacion ON ventilacion.idsesion=programacion.idsesion where programacion.id='$id' and programacion.fecha='$fecha'";
			//echo $sql2;
			try{
				$obj2 = $pdo->prepare($sql2);
				$obj2->execute();
			}catch(Exception $ex){
				echo "<script languaje = javascript> alert('Error sesion no existe.');"."self.location='../menuadmin.php'</script>";
				return;
			}
			$row2 = $obj2->fetch(PDO::FETCH_ASSOC);
			$aforoMax = $row2['aforoMax'];
			array_push($aforo_aula, $aforoMax);
			array_push($fechas, $fecha);
			array_push($aforo_covid_aula,$aforo_covid);
		}
		//print_r($aforo_aula);
		//print_r($aforo_covid_aula);
		//print_r($fechas);
	}
?>
	
	<canvas id="graficaAsistencia" height="40vh" width="100vw"></canvas>
	<script type="text/javascript">
		const aforo_aula = <?php echo json_encode($aforo_aula) ?>;
		const fechas = <?php echo json_encode($fechas); ?>;
		const aforo_covid_aula = <?php echo json_encode($aforo_covid_aula); ?>;
		
		const $graficaAsistencia = document.querySelector("#graficaAsistencia");
		new Chart($graficaAsistencia, {
			data: {
				labels: fechas,
				datasets: [{
					type: 'bar',
					label: 'Aforo Actual',
					data: aforo_aula,
					backgroundColor: 'rgba(0, 255, 0, 0.2)', 
					borderColor: 'rgba(0, 255, 0, 1)',
					borderWidth: 1 
				}, {
					type: 'line',
					label: 'AFORO',
					data: aforo_covid_aula,
					backgroundColor: 'rgba(0, 0, 0, 1)', 
					borderColor: 'rgba(0, 0, 0, 1)',
					borderWidth: 1 
				}],
				pointRadius: 15,
				pointHoverRadius: 15,
			},
		});
	</script>
	<br>
	<form action="ver_lista.php" method="POST">
		<div class="row" align="center"> 
			<input name='cursoSelect' value="<?php echo $cursoSelect ?>" type='hidden'/>
			<input name='campusSelect' value="<?php echo $campusSelect ?>" type='hidden'/>
			<input name='aulaSelect' value="<?php echo $aulaSelect ?>" type='hidden'/>
			<button id="vergraf" class="btn btn-primary" type="submit" style="width: 120px;margin-right: auto; margin-left: auto;">Ver Lista</button>
		</div>
	</form>
</div>