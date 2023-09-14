<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
							<div class="panel-heading">Todas los registros cargados</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Fecha</th>
											<th>Usuario</th>
											<th>Tipo</th>
											<th>Dirección</th>
											<th>Barrio</th>
											<th>Desccripción</th>
											<th>Imagenes</th>
											<th>Ubicacion</th>
											<th>Estado</th>
											<th>Accions</th> 
										</tr>
									</thead>
									<tbody>
<?php	
$email="";
$ret="select * from vandalismos where estado<>'0' order by fecha";
$stmt= $mysqli->prepare($ret) ;
// $stmt->bind_param('s',$aid);
$stmt->execute() ;
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {
		$aid=$row->user;
		$ret1="select * from userregistration where id=?";
		$stmt1= $mysqli->prepare($ret1) ;
		$stmt1->bind_param('i',$aid);
		$stmt1->execute() ;
		$res1=$stmt1->get_result();
		while($row1=$res1->fetch_object())
			{
				$email=$row1->email;
			}
	  	?>
<tr>
<td><?php echo $row->fecha;?></td>
<td><?php echo $email;?></td>
<td><?php echo $row->tipo;?></td>
<td><?php echo $row->direccion;?></td>
<td><?php echo $row->departamento;?></td>
<td><?php echo $row->descripcion;?></td>

<td>
<?php
                                            foreach(explode(';',$row->imagenes) as $key1=>$image)
                                            {
                                                echo("<a style='color:#172326;' href='$image' target='_blank' >$image</a><br>");
                                            }
                                            ?>
</td>
<td><a style='color:#172326;' href="https://www.google.com/maps?q=<?php echo $row->direccion.", ".$row->departamento.", Paraguay"; ?>" target="_blank">Ver ubicación</a> 
<?php 
// echo $row->search_addr.", $row->search_latitude, $row->search_longitude";
?></td>
<td>		
	<select name="estado" id="estado" texto="<?php echo $row->id;?>">
	<option value="En proceso">En proceso</option>
	<option value="Recibido" selected>Recibir</option>
	<option value="Rechazado">Rechazar</option>
	</select>
</td>
		<td>
		<button type="button" class="btn btn-danger" onclick="elimiar(<?php echo $row->id;?>);">Eliminar</button>
		</td>								</tr>
									<?php
$cnt=$cnt+1;
									 } ?>
											
										
									</tbody>
								</table>

								<script>
									function elimiar(params) {
										console.log("vamos a eliminar:"+params);
										$.ajax({
												url: 'eliminar_vandalismo.php?id='+params,
												data: {},
												type: 'POST',
												success: function(response) {
													alert('Vandalismo Eliminado.');
													location.reload();
												},
												statusCode: {
													404: function() {
														alert('web not found');
													}
												},
												error: function(x, xs, xt) {
													alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
												}
											});
									}
									$("#estado").change(function (params) {
										let estado=$('select[name="estado"] option:selected').val();
										let id=$("#estado").attr("texto");
										console.log("valor seleccionado:"+estado);
										console.log("id seleccionado:"+id);
										$.ajax({
												url: 'modificar_vandalismo.php?id='+id+'&estado='+estado,
												data: {},
												type: 'POST',
												success: function(response) {
													alert('Vandalismo modificado.');
												},
												statusCode: {
													404: function() {
														alert('web not found');
													}
												},
												error: function(x, xs, xt) {
													alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
												}
											});
									})
								</script>
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
