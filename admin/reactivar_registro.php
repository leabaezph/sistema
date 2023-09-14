<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();



$id=$_POST['id'];
$query="UPDATE  registration SET state=0 , reason='' WHERE (id=$id)";
$stmt = $mysqli->prepare($query);
// $rc=$stmt->bind_param('si',$motivo,$id);
$stmt->execute();

$fecha=date("Y-m-d");
$hora=date("h:i:s");
$id_user=$_SESSION['id'];
$queryNotification="insert into  notification(iduser,coment,status, date,time, idregistration) values(?,'Registro reactivado por el admin',0,?,?,?)";
$stmtNotification = $mysqli->prepare($queryNotification);
$rcNotification=$stmtNotification->bind_param('issi', $id_user,$fecha, $hora,$id);
$stmtNotification->execute();

echo"<script>alert('reactivacion cargada');</script>";
