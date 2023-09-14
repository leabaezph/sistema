<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Vandalismos</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
			<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title" style="margin-top: 2%">Vandalismos registrados</h2>
						<div class="panel panel-default">
							<div class="panel-heading">Todos los registros cargados</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Tipo</th>
											<th>Dirección</th>
											<th>Barrio</th>
											<th>Desccripción</th>
											<th>Imagenes</th>
											<th>Ubicacion</th>
											<th>Estado</th>
										</tr>
									</thead>
									<tbody>
<?php	
$aid=$_SESSION['id'];
$ret="select * from vandalismos where user=?";
$stmt= $mysqli->prepare($ret) ;
$stmt->bind_param('s',$aid);
$stmt->execute() ;
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {
	  	?>
<tr>
	<!-- <td><?php echo $cnt;;?></td> -->
<!-- <td><?php echo $row->userEmail;?></td> -->
<td><?php echo $row->tipo;?></td>
<td><?php echo $row->direccion;?></td>
<td><?php echo $row->departamento;?></td>
<td><?php echo $row->descripcion;?></td>
<td>
<?php
                                            foreach(explode(';',$row->imagenes) as $key1=>$image)
                                            {
                                                echo("<a href='admin/$image' style='color:#172326;' target='_blank' >$image</a><br>");
                                            }
                                            ?>
</td>
<td><a style='color:#172326;' href="https://www.google.com/maps?q=<?php echo $row->direccion.", ".$row->departamento.", Paraguay"; ?>" target="_blank">Ver ubicación</a> 
<?php 
// echo $row->search_addr.", $row->search_latitude, $row->search_longitude";
?></td>
<td><?php
if ($row->estado=="0") {
	echo("Eliminado");
} else{
	echo $row->estado;
}
?></td>
										</tr>
									<?php
$cnt=$cnt+1;
									 } ?>
											
										
									</tbody>
								</table>

								
							</div>
						</div>

					
					</div>
				</div>

			

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>
