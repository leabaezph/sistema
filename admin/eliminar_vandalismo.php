<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
$id=$_REQUEST['id'];
// $estado=$_REQUEST['estado'];

// verificamos si esta cargado
$query="UPDATE  vandalismos SET estado='0' WHERE (id=$id)";
$stmt = $mysqli->prepare($query);
// $rc=$stmt->bind_param('si',$motivo,$id);
$stmt->execute();


$fecha=date("Y-m-d");
$hora=date("h:i:s");
$id_user=$_SESSION['id'];
$queryNotification="insert into  notification(iduser,coment,status, date,time,idregistration) values(?,'Se elimino el vandalismo $id',0,?,?,?)";
$stmtNotification = $mysqli->prepare($queryNotification);
$rcNotification=$stmtNotification->bind_param('issi', $id_user,$fecha, $hora,$id);
$stmtNotification->execute();
echo"ok";



