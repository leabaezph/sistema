<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// foreach($_POST as $campo => $valor){
//     echo "- ". $campo ." = ". $valor;
//   }
//code for registration

$id=$_POST['id'];
$motivo=$_POST['motivo'];
$query="UPDATE  registration SET state=1 , reason='$motivo' WHERE (id=$id)";
$stmt = $mysqli->prepare($query);
// $rc=$stmt->bind_param('si',$motivo,$id);
$stmt->execute();

$fecha=date("Y-m-d");
$hora=date("h:i:s");
$id_user=$_SESSION['id'];
$queryNotification="insert into  notification(iduser,coment,status, date,time,idregistration) values(?,'Registro de baja',0,?,?,?)";
$stmtNotification = $mysqli->prepare($queryNotification);
$rcNotification=$stmtNotification->bind_param('issi', $id_user,$fecha, $hora,$id);
$stmtNotification->execute();
echo"<script>alert('cancelacion cargada');</script>";
