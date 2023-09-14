<style>
#geomap {
    width: 100%;
    height: 400px;
}
</style>
<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
// //code for registration
if(isset($_POST['submit']))
{

$tipo=$_POST['tipo'];
$direccion=$_POST['direccion'];
$departamento=$_POST['departamento'];
$descripcion=$_POST['descripcion'];
$search_addr=$_POST['search_addr'];
$search_latitude=$_POST['search_latitude'];
$search_longitude=$_POST['search_longitude'];


$images="";

//Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
{
    //Validamos que el archivo exista
    if($_FILES["archivo"]["name"][$key]) {
        $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
        $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo    
        // cargamos imagenes para el admin
        $directorioAdmin = 'admin/docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
        if(!file_exists($directorioAdmin)){
            mkdir($directorioAdmin, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
        }else{
        }
        $diradmin=opendir($directorioAdmin); //Abrimos el directorio de destino
        // $target_path_admin = $directorioAdmin.'docs/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
        $target_path_admin = "docs/".$filename; //Indicamos la ruta de destino, así como el nombre del archivo
        $images=$images.$target_path_admin.";";
        //Movemos y validamos que el archivo se haya cargado correctamente
        //El primer campo es el origen y el segundo el destino
        // if(move_uploaded_file($source, 'admin/'.$target_path_admin)) {	
        if(move_uploaded_file($source, "admin/".$target_path_admin)) {	
            // echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
            } else {	
            // echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
        }
        closedir($diradmin); //Cerramos el directorio de destino
    }
}


$id_user=$_SESSION['id'];
// $query="insert into  registration(roomno,foodstatus,stayfrom,duration,course,regno,firstName,middleName,lastName,gender,contactno,emailid,egycontactno,corresAddress,corresState,corresPincode, images,reason, m_regno,m_fname,m_lname,m_birth,m_ogender,m_ocontact,m_outfit,m_event,m_address,m_city, accompanying, Address, Latitude, Longitude) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'',?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
// $stmt = $mysqli->prepare($query);
// $rc=$stmt->bind_param('iisisissssisissisisssssssssssss',$roomno,$foodstatus,$stayfrom,$duration,$course,$regno,$fname,$mname,$lname,$gender,$contactno,$emailid,$emcntno,$caddress,$cstate,$cpincode, $images,   $m_regno,$m_fname,$m_lname,$m_birth,$m_ogender,$m_ocontact,$m_outfit,$m_event,$m_address,$m_city, $accompanying, $Address, $Latitude, $Longitude);
// $stmt->execute();

$query="insert into  vandalismos(tipo,direccion,departamento,descripcion,imagenes,search_addr,search_latitude,search_longitude,user, estado) values(?,?,?,?,?,?,?,?,?,'En proceso')";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('ssssssssi',$tipo,$direccion,$departamento,$descripcion,$images,$search_addr,$search_latitude,$search_longitude, $id_user);
$stmt->execute();


$retlastid="select id from vandalismos ORDER BY id DESC LIMIT 1";
$stmtlastid= $mysqli->prepare($retlastid) ;
$stmtlastid->execute() ;
$reslastid=$stmtlastid->get_result();
while($rowlastid=$reslastid->fetch_object())
	  {
        $lastid=$rowlastid->id;
      }

$fecha=date("Y-m-d");
$hora=date("h:i:s");

$queryNotification="insert into  notification(iduser,coment,status, date,time, idregistration) values(?,'Nuevo registro cargado',0,?,?,?)";
$stmtNotification = $mysqli->prepare($queryNotification);
$rcNotification=$stmtNotification->bind_param('issi', $id_user,$fecha, $hora,  $lastid);
$stmtNotification->execute();

echo"<script>alert('El acto se registró con exíto');</script>";
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
    <title>DENUNCIAS DE VANDALISMO</title>
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
    <script>
    function getSeater(val) {
        $.ajax({
            type: "POST",
            url: "get_seater.php",
            data: 'roomid=' + val,
            success: function(data) {
                //alert(data);
                $('#seater').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "get_seater.php",
            data: 'rid=' + val,
            success: function(data) {
                //alert(data);
                $('#fpm').val(data);
            }
        });
    }
    </script>

</head>

<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php include('includes/sidebar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Registrar caso de vandalismo </h2>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Ingresar Informacion</div>
                                    <div class="panel-body">
                                        <!-- <form id="product-form" class="form-horizontal" enctype="multipart/form-data"> -->
                                        <form method="post" action="" class="form-horizontal"
                                            enctype="multipart/form-data">
                                            <?php
$uid=$_SESSION['login'];
				// 			 $stmt=$mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? || regno=? ");
				// $stmt->bind_param('ss',$uid,$uid);
				// $stmt->execute();
				// $stmt -> bind_result($email);
				// $rs=$stmt->fetch();
				// $stmt->close();
				if(false)
				{ ?>
                                            <h3 style="color: red" align="center">Visualizar Reporte</h3>
                                            <div align="center">
                                                <div class="col-md-4">&nbsp;</div>
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-success text-light">
                                                            <div class="stat-panel text-center">

                                                                <div class="stat-panel-number h1 ">Reporte</div>

                                                            </div>
                                                        </div>
                                                        <a href="vandalismo-detail.php"
                                                            class="block-anchor panel-footer text-center">ver&nbsp;
                                                            <i class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }
				else{
								
							?>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    <h4 style="color: green" align="left">Caso de vandalismo </h4>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tipo de incidencia</label>
                                                <div class="col-sm-8">
                                                    <select name="tipo" id="tipo" class="form-control">
                                                        <option value="presencia de pandillas">Presencia de pandillas
                                                        </option>
                                                        <option value="bandas en las calles">Bandas en las calles
                                                        </option>
                                                        <option value="venta de drogas">Venta de drogas </option>
                                                        <option value="Riñas">Riñas</option>
                                                        <option value="peleas en las calles">Peleas en las calles
                                                        </option>
                                                        <option value="consumo de alcohol en la vía pública">Consumo de
                                                            alcohol en la vía pública</option>
                                                        <option value="calles sin iluminación">Calles sin iluminación
                                                        </option>
                                                        <option value="Otros">Otros
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Dirección: </label>
                                                <div class="col-sm-8">
                                                    <input type="direccion" name="direccion" id="direccion"
                                                        class="form-control" value="">
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Barrios </label>
                                                <div class="col-sm-8">
                                                    <select name="departamento" id="departamento" class="form-control">
                                                        <option value="Chaipé">Chaipé</option>
                                                        <option value="San Pedro ">San Pedro </option>
                                                        <option value="Curupayty">Curupayty</option>
                                                        <option value="San Antonio">San Antonio</option>
                                                        <option value="Quiteria">Quiteria</option>
                                                        <option value="Nueva Esperanza "> Nueva Esperanza </option>
                                                        <option value="María Auxiliadora ">María Auxiliadora </option>
                                                        <option value="Kennedy">Kennedy</option>
                                                        <option value="Mbói Ka'e">Mbói Ka'e</option>
                                                        <option value="Santa Rosa">Santa Rosa</option>
                                                        <option value="San Blas">San Blas</option>
                                                        <option value="Padre Bolik ">Padre Bolik </option>
                                                        <option value="Bernardino Caballero ">Bernardino Caballero </option>
                                                        <option value=">La Paz ">La Paz </option>
                                                        <option value="Villa Cándida ">Villa Cándida </option>
                                                        <option value="Boquerón">Boquerón</option>
                                                        <option value="Centro">Centro</option>
                                                        <option value="Carlos Antonio López ">Carlos Antonio López </option>
                                                        <option value="Zona Alta  ">Zona Alta  </option>
                                                        <option value="Juan León Mallorquín ">Juan León Mallorquín </option>
                                                        <option value="Catedral">Catedral</option>
                                                        <option value="La Victoria ">La Victoria </option>
                                                        <option value="Poti'y ">Poti'y </option>
                                                        <option value="Obrero">Obrero</option>
                                                        <option value="Ciudad Nueva ">Ciudad Nueva </option>
                                                        <option value="San Roque González ">San Roque González </option>
                                                        <option value="Buena Vista ">Buena Vista  </option>
                                                        <option value="Pacu Kua ">Pacu Kua </option>
                                                        <option value="Sagrada Familia ">Sagrada Familia </option>
                                                        <option value="Fátima">Fátima</option>
                                                        <option value="San Isidro ">San Isidro </option>
                                                        <option value="Santa María Santillán ">Santa María Santillán </option>
                                                        <option value="Itá Angu'a ">Itá Angu'a </option>
                                                        <option value="Nueva Ucrania ">Nueva Ucrania </option>
                                                        <option value="4 Potrero ">4 Potrero </option>
                                                        <option value="Cerrito">Cerrito</option>
                                                        <option value="Santa Elena ">Santa Elena </option>
                                                        <option value="San José Obrero ">San José Obrero </option>
                                                        <option value=">Urú Sapucái ">Urú Sapucái </option>
                                                        <option value="San Isidro Sapucái ">San Isidro Sapucái </option>
                                                        <option value="San Luis ">San Luis </option>
                                                        <option value="Santo Domingo ">Santo Domingo </option>
                                                        <option value="Itá Paso">Itá Paso</option>
                                                        <option value="El Paraíso ">El Paraíso </option>
                                                        <option value="Santa Cruz">Santa Cruz</option>
                                                        <option value="Los Arrabales ">Los Arrabales </option>
                                                        <option value="8 de diciembre ">8 de diciembre </option>
                                                        <option value="San Rafael ">San Rafael </option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Descripción: </label>
                                                <div class="col-sm-8">
                                                    <textarea rows="5" name="descripcion" id="descripcion"
                                                        class="form-control" required="required"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <label class="col-sm-2 control-label">Imagenes:</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control" id="archivo[]"
                                                            name="archivo[]" multiple="">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Referencia geográfica: </label>
                                                <div class="col-sm-4">
                                                    <input type='text' id="search_location" name='search_location'
                                                        class="form-control" placeholder='Pon la dirección aquí' />
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type='buttom' id="buttonProcessMap" value='Localizar'
                                                        class="btn btn-success" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> </label>
                                                <div class="col-sm-8">
                                                    <!-- display google map -->
                                                    <div id="geomap"></div>

                                                    <!-- display selected location information -->
                                                    <!-- <h4>Location Details</h4> -->
                                                    <input type="text" class="search_addr" name="search_addr" size="45"
                                                        style="display:none">
                                                    <input type="text" class="search_latitude" name="search_latitude"
                                                        size="30" style="display:none">
                                                    <input type="text" class="search_longitude" name="search_longitude"
                                                        size="30" style="display:none">
                                                </div>
                                            </div>





                                            <div class="col-sm-6 col-sm-offset-4">
                                                <button class="btn btn-default" type="submit">Cancel</button>
                                                <input type="submit" name="submit" Value="Register"
                                                    class="btn btn-primary">
                                            </div>
                                        </form>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"
        integrity="sha512-9pm50HHbDIEyz2RV/g2tn1ZbBdiTlgV7FwcQhIhvykX6qbQitydd6rF19iLmOqmJVUYq90VL2HiIUHjUMQA5fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALOm_7-fAGREy0WPc3XrMDiQ-VuFwORvk&callback=initMap">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
<script type="text/javascript">

</script>
<script type="text/javascript">
var geocoder;
var map;
var marker;

/*
 * Google Map with marker
 */
function initialize() {
    var initialLat = $('.search_latitude').val();
    var initialLong = $('.search_longitude').val();
    initialLat = initialLat ? initialLat : 36.169648;
    initialLong = initialLong ? initialLong : -115.141000;

    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {
        zoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("geomap"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: latlng
    });

    google.maps.event.addListener(marker, "dragend", function() {
        var point = marker.getPosition();
        map.panTo(point);
        geocoder.geocode({
            'latLng': marker.getPosition()
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            }
        });
    });

}


$(document).ready(function() {
    //load google map
    initialize();

    /*
     * autocomplete location search
     */
    var PostCodeid = '#search_location';
    // $(function () {
    //     $(PostCodeid).autocomplete({
    //         source: function (request, response) {
    //             geocoder.geocode({
    //                 'address': request.term
    //             }, function (results, status) {
    //                 response($.map(results, function (item) {
    //                     return {
    //                         label: item.formatted_address,
    //                         value: item.formatted_address,
    //                         lat: item.geometry.location.lat(),
    //                         lon: item.geometry.location.lng()
    //                     };
    //                 }));
    //             });
    //         },
    //         select: function (event, ui) {
    //             $('.search_addr').val(ui.item.value);
    //             $('.search_latitude').val(ui.item.lat);
    //             $('.search_longitude').val(ui.item.lon);
    //             var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
    //             marker.setPosition(latlng);
    //             initialize();
    //         }
    //     });
    // });

    /*
     * Point location on google map
     */
    $('#buttonProcessMap').click(function(e) {
        var address = $(PostCodeid).val();
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
        e.preventDefault();
    });

    //Add listener to marker for reverse geocoding
    google.maps.event.addListener(marker, 'drag', function() {
        geocoder.geocode({
            'latLng': marker.getPosition()
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('.search_addr').val(results[0].formatted_address);
                    $('.search_latitude').val(marker.getPosition().lat());
                    $('.search_longitude').val(marker.getPosition().lng());
                }
            }
        });
    });

















    $('#m_regno').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#regno').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('input[type="checkbox"]').click(function() {
        if ($(this).prop("checked") == true) {
            $('#paddress').val($('#address').val());
            $('#pcity').val($('#city').val());
            $('#pstate').val($('#state').val());
            $('#ppincode').val($('#pincode').val());
        }

    });
});
</script>
<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'roomno=' + $("#room").val(),
        type: "POST",
        success: function(data) {
            $("#room-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {}
    });
}
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('#duration').keyup(function() {
        var fetch_dbid = $(this).val();
        $.ajax({
            type: 'POST',
            url: "ins-amt.php?action=userid",
            data: {
                userinfo: fetch_dbid
            },
            success: function(data) {
                $('.result').val(data);
            }
        });


    })
});
</script>

</html>