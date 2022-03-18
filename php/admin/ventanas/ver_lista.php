<meta charset="utf-8">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<a id="menu" href="../menuadmin.php" style="margin-top:10px; margin-left: 20px;">Men&uacute; Principal</a>
	<br><br>
<table class="table table-bordered text-center" style="width: 95%;margin-right: auto; margin-left: auto;">
	<?php
		/*Por seguridad debo evaluar si el ingreso a menú admin es por sesión*/f
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
	<thead>
		<th>Fecha</th>
		<th>C&oacute;digo</th>
		<th>Nombre</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Hora de Entrada</th>
		<th>Hora de Salida</th>
		<th>Asistencia</th>
	</thead>
	<tbody>
		<h3 class="h3" style="margin-left:60px;">Lista de Asistencia a Sesi&oacute;n:</h3>
		<?php
		// cursoSelect, campusSelect, aulaSelect [curso - programacion - asistencia]
		// fecha, codigo, nombre, apellidop, apellidom, hora_entrada, hora_salida, asistencia
			if($_SERVER["REQUEST_METHOD"]=="POST"){
				extract($_POST); 
				$sql = "select id from cursos where curso='$cursoSelect' and campus='$campusSelect' and aula='$aulaSelect'";
				//echo $sql;
				$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sotr','root','');
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$obj = $pdo->prepare($sql);
					$obj->execute();
				}catch(Exception $ex){
					echo "<script languaje = javascript> alert('Error al seleccionando alumnos.');"."self.location='../../cerrar.php'</script>";
					return;
				}
				while($row = $obj->fetch(PDO::FETCH_ASSOC)){
					extract($row); 					
					$sql2 = "select programacion.fecha, asistencia.codigo, personal.nombre, personal.apellidop, personal.apellidom, asistencia.hora_entrada, asistencia.hora_salida, asistencia.estado from (((programacion INNER JOIN cursos ON programacion.id=cursos.id) INNER JOIN asistencia ON programacion.idsesion=asistencia.idsesion) INNER JOIN personal ON personal.codigo=asistencia.codigo) where cursos.id='$id'";
					try{
						$obj2 = $pdo->prepare($sql2);
						$obj2->execute();
					}catch(Exception $ex){
						echo "<script languaje = javascript> alert('Error al seleccionando sesion.');"."self.location='../../cerrar.php'</script>";
						return;
					}
					while($row2 = $obj2->fetch(PDO::FETCH_ASSOC)){
						extract($row2);
						echo "<tr>";
						echo "<td>".$fecha."</td>";
						echo "<td>".$codigo."</td>";
						echo "<td>".$nombre."</td>";
						echo "<td>".$apellidop."</td>";
						echo "<td>".$apellidom."</td>";
						echo "<td>".$hora_entrada."</td>";
						echo "<td>".$hora_salida."</td>";
						echo "<td>".$estado."</td>";
						echo "</tr>";
					}
				}
			}
		?>
	</tbody>
</table>