<?php
session_start();
include('includes/config.php');
if(isset($_POST['submit']))
{
$regno=$_POST['regno'];
$fname=$_POST['fname'];
$mname=$_POST['mname'];
$lname=$_POST['lname'];
$gender=$_POST['gender'];
$contactno=$_POST['contact'];
$emailid=$_POST['email'];
$password=$_POST['password'];
	$result ="SELECT count(*) FROM userRegistration WHERE email=? || regNo=?";
		$stmt = $mysqli->prepare($result);
		$stmt->bind_param('ss',$email,$regno);
		$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count>0)
{
echo"<script>alert('Número de registro o ID de correo electrónico ya registrado.');</script>";
}else{

$query="insert into  userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password) values(?,?,?,?,?,?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('sssssiss',$regno,$fname,$mname,$lname,$gender,$contactno,$emailid,$password);
$stmt->execute();
echo"<script>alert('El usuario se registro con exíto');</script>";
}
}
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
    <title>User Registration</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">
    function valid() {
        if (document.registration.password.value != document.registration.cpassword.value) {
            alert("¡Vuelva a escribir la contraseña no coincide!  ");
            document.registration.cpassword.focus();
            return false;
        }
        return true;
    }
    </script>
</head>

<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php 
		// include('includes/sidebar.php');
		?>
        <!-- <div class="content-wrapper"> -->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Nuevo Registro </h2>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Completar Informacion</div>
                                    <div class="panel-body">
                                        <form method="post" action="" name="registration" class="form-horizontal"
                                            onSubmit="return valid();">



                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> Numero de Documento : </label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="regno" id="regno" class="form-control"
                                                        required="required" onBlur="checkRegnoAvailability()">
                                                    <span id="user-reg-availability" style="font-size:12px;"></span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Primer Nombre : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="fname" id="fname" class="form-control"
                                                        required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Segundo Nombre : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="mname" id="mname" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellidos : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="lname" id="lname" class="form-control"
                                                        required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Genero : </label>
                                                <div class="col-sm-8">
                                                    <select name="gender" class="form-control" required="required">
                                                        <option value="">Seleccionar Genero</option>
                                                        <option value="male">Masculino</option>
                                                        <option value="female">Femenino</option>
                                                        <option value="others">Otros</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Numero de Contacto : </label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="contact" id="contact"
                                                        class="form-control" required="required">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Correo Electronico: </label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="email" id="email" class="form-control"
                                                        onBlur="checkAvailability()" required="required">
                                                    <span id="user-availability-status" style="font-size:12px;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Contraseña: </label>
                                                <div class="col-sm-8">
                                                    <input type="password" name="password" id="password"
                                                        class="form-control" required="required">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Confirmar Contraseña : </label>
                                                <div class="col-sm-8">
                                                    <input type="password" name="cpassword" id="cpassword"
                                                        class="form-control" required="required">
                                                </div>
                                            </div>




                                            <div class="col-sm-6 col-sm-offset-4">
                                                <button class="btn btn-default" type="reset">Restaurar</button>
                                                <input type="submit" name="submit" Value="Registrar"
                                                    class="btn btn-primary">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
    </div>
    </div>
    </div>
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
<script>
function checkAvailability() {

    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'emailid=' + $("#email").val(),
        type: "POST",
        success: function(data) {
            $("#user-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {
            event.preventDefault();
            alert('error');
        }
    });
}
</script>
<script>
function checkRegnoAvailability() {

    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'regno=' + $("#regno").val(),
        type: "POST",
        success: function(data) {
            $("#user-reg-availability").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {
            event.preventDefault();
            alert('error');
        }
    });
}
</script>

</html>