<style>
    #geomap{
    width: 100%;
    height: 400px;
}
</style>
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
    <title>Vandalismos regsitrados</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <script language="javascript" type="text/javascript">
    var popUpWin = 0;

    function popUpWindow(URLStr, left, top, width, height) {
        if (popUpWin) {
            if (!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin',
            'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' +
            510 + ',height=' + 430 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
    }
    </script>

</head>

<body>
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/sidebar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row" id="print">


                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:3%">Vandalismos registrados</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Vandalismo</div>
                            <div class="panel-body">
                                <table id="zctb" class="table table-bordered " cellspacing="0" width="100%" border="1">

                                    <span style="float:left"><i class="fa fa-print fa-2x" aria-hidden="true"
                                            OnClick="CallPrint(this.value)" style="cursor:pointer"
                                            title="Print the Report"></i></span>
                                    <tbody>
                                        <?php	
$aid=$_SESSION['login'];
$ret="select * from vandalismo where (emailid=? || regno	=?)";
$stmt= $mysqli->prepare($ret) ;
$stmt->bind_param('ss',$aid,$aid);
$stmt->execute() ;
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {
	  	?>

                                        <tr>
                                            <td colspan="6" style="text-align:center; color:blue">
                                                <h3>Informacion</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align:center; color:blue">
                                                <h4>Estado del registro:
                                                    <?php 
                                                    if ($row->state==0) {
                                                        echo("Activo");
                                                    }else{
                                                        echo("Baja:".$row->reason);
                                                    }
                                                    ?>
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Numero de Documento :</th>
                                            <td><?php echo $row->regno;?></td>
                                            <th>Fecha :</th>
                                            <td colspan="3"><?php echo $row->postingDate;?></td>
                                        </tr>



                                        <tr>
                                            <!-- <td><b>Esto se puede borrar tamb desde la BD :</b></td>
                                            <td><?php echo $row->roomno;?></td>
                                            <td><b>Seater :</b></td>
                                            <td><?php echo "";?></td>
                                            <td><b>Fees PM :</b></td>
                                            <td><?php echo "";?></td> -->
                                        </tr>

                                        <tr>
                                            <!-- <td><b>Esto se puede borrar tamb desde la BD:</b></td>
                                            <td>
                                                <?php if($row->foodstatus==0)
{
echo "Without Food";
}
else
{
echo "With Food";
}
;?></td>
                                            <td><b>Esto se puede borrar tamb desde la BD :</b></td>
                                            <td><?php echo $row->stayfrom;?></td>
                                            <td><b>Duration:</b></td>
                                            <td><?php echo $dr=$row->duration;?> Months</td> -->
                                        </tr>

                                        <tr>
                                            <!-- <th>Esto se puede borrar tamb desde la BD:</th>
                                            <td><?php echo $hf=$dr*$fpm?></td>
                                            <th>Food Fee:</th>
                                            <td colspan="3"><?php 
if($row->foodstatus==1)
{ 
echo $ff=(2000*$dr);
} else { 
echo $ff=0;
echo "<span style='padding-left:2%; color:red;'>(You booked hostel without food).<span>";
}?></td> -->
                                        </tr>
                                        <tr>
                                            <!-- <th>Esto se puede borrar tamb desde la BD :</th>
                                            <th colspan="5"><?php echo $hf+$ff;?></th> -->
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="6" style="color:red">
                                                <h4>Datos personales</h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Reg No. :</b></td>
                                            <td><?php echo $row->regno;?></td>
                                            <td><b>Full Name :</b></td>
                                            <td><?php echo $row->firstName;?><?php echo $row->middleName;?><?php echo $row->lastName;?>
                                            </td>
                                            <td><b>Email :</b></td>
                                            <td><?php echo $row->emailid;?></td>
                                        </tr>


                                        <tr>
                                            <td><b>Contact No. :</b></td>
                                            <td><?php echo $row->contactno;?></td>
                                            <td><b>Gender :</b></td>
                                            <td><?php echo $row->gender;?></td>
                                            <td><b>Course :</b></td>
                                            <td><?php echo $row->course;?></td>
                                        </tr>


                                        <tr>
                                            <td><b>Emergency Contact No. :</b></td>
                                            <td><?php echo $row->egycontactno;?></td>
                                            <td><b>Guardian Name :</b></td>
                                            <td><?php echo $row->guardianName;?></td>
                                            <td><b>Guardian Relation :</b></td>
                                            <td><?php echo $row->guardianRelation;?></td>
                                        </tr>

                                        <tr>
                                            <td><b>Guardian Contact No. :</b></td>
                                            <td colspan="6"><?php echo $row->guardianContactno;?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="6" style="color:blue">
                                                <h4>Addresses</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Correspondense Address</b></td>
                                            <td colspan="2">
                                                <?php echo $row->corresAddress;?><br />
                                                <?php echo $row->corresCIty;?>, <?php echo $row->corresPincode;?><br />
                                                <?php echo $row->corresState;?>


                                            </td>
                                            <td><b>Permanent Address</b></td>
                                            <td colspan="2">
                                                <?php echo $row->pmntAddress;?><br />
                                                <?php echo $row->pmntCity;?>, <?php echo $row->pmntPincode;?><br />
                                                <?php echo $row->pmnatetState;?>

                                            </td>
                                        </tr>



                                        <!-- missing person -->
                                        <tr>
                                            <td colspan="6" style="color:red">
                                                <h4>Missing person</h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Reg No. :</b></td>
                                            <td><?php echo $row->m_regno;?></td>
                                            <td><b>Full Name :</b></td>
                                            <td><?php echo $row->m_fname;?><?php echo $row->m_lname;?>
                                            </td>
                                            <td><b>Birth :</b></td>
                                            <td><?php echo $row->m_birth;?></td>
                                        </tr>


                                        <tr>
                                            <td><b>Contact No. :</b></td>
                                            <td><?php echo $row->m_ocontact;?></td>
                                            <td><b>Gender :</b></td>
                                            <td><?php echo $row->m_ogender;?></td>
                                            <td><b></b></td>
                                            <td><?php echo "";?></td>
                                        </tr>


                                        <tr>
                                            <td><b>Contact No. :</b></td>
                                            <td><?php echo $row->m_ocontact;?></td>
                                            <td><b>m_outfit :</b></td>
                                            <td><?php echo $row->m_outfit;?></td>
                                            <td><b>event :</b></td>
                                            <td><?php echo $row->m_event;?></td>
                                        </tr>

                                        <!-- <tr>
                                            <td><b>Guardian Contact No. :</b></td>
                                            <td colspan="6"><?php echo "";?></td>
                                        </tr> -->

                                        <tr>
                                            <td colspan="6" style="color:blue">
                                                <h4>Addresses</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Permanent Address</b></td>
                                            <td colspan="2">
                                                <?php echo $row->m_address;?><br />
                                                <?php echo $row->m_city;?><br />
                                                <?php echo "";?>


                                            </td>
                                            <td><b>Permanent Address</b></td>
                                            <td colspan="2">
                                                <?php echo $row->m_address;?><br />
                                                <?php echo "";?><br />
                                                <?php echo "";?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Imagenes :</th>
                                            <th colspan='5'>
                                            <?php
                                            foreach(explode(';',$row->images) as $key1=>$image)
                                            {
                                                echo("<a href='admin/$image' target='_blank' >$image</a><br>");
                                            }
                                            ?>
                                            </th>
                                        </tr>


                                        <?php
$cnt=$cnt+1;
?>
</tbody>
</table>
<!-- style="display:none" -->
<input type="text" class="search_addr" name="search_addr" id="search_addr" value="<?php echo $row->Address; ?>" size="45" style="display:none">
<div id="geomap"></div>
<input type="text" class="search_addr" name="search_addr" size="45" style="display:none">
 <input type="text" class="search_latitude" name="search_latitude" size="30" style="display:none">
 <input type="text" class="search_longitude" name="search_longitude" size="30" style="display:none">
 <br>
<?php
if ($row->state==0) {
    ?>
    <button type="button" onclick="cancelarBusqueda(<?php echo $row->id; ?>)" class="btn btn-danger">Cancelar busqueda</button>
    <?php 
}else{
    ?>
    <button type="button" onclick="reactivarBusqueda(<?php echo $row->id; ?>)" class="btn btn-primary">Reactivar busqueda</button>
    <?php 
}
} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Motivo de cancelación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div> -->
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Motivo:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
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
    <!-- <script src="js/main.js"></script> -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALOm_7-fAGREy0WPc3XrMDiQ-VuFwORvk&callback=initMap"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
         var geocoder;
var map;
var marker;

/*
 * Google Map with marker
 */
    function initialize() {
        var initialLat = $('.search_latitude').val();
        var initialLong = $('.search_longitude').val();
        initialLat = initialLat?initialLat:36.169648;
        initialLong = initialLong?initialLong:-115.141000;

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

        google.maps.event.addListener(marker, "dragend", function () {
            var point = marker.getPosition();
            map.panTo(point);
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    // $('.search_addr').val(results[0].formatted_address);
                    // $('.search_latitude').val(marker.getPosition().lat());
                    // $('.search_longitude').val(marker.getPosition().lng());
                }
            });
        });

    }

    function cancelarBusqueda(id) {
        console.log("busqueda cancleada para el registro:"+id);
        let reason = prompt("Ingrese el motivo de su cancelación", "Ej: Ya lo encontramos/Descripcion de la cancelacion");
        let   text;
        if (reason == null || reason == "") {
          text = "User cancelled the prompt.";
        } else {
            text = "Hello " + reason + "! How are you today?";
            $.ajax({
                type:'POST',
                url:'cargar_motivo.php?id='+id+'&motivo='+reason,
                data:{'id':id, 'motivo':reason},
                success:function(response){
                    console.log(response);
                    console.log("se cargo bien");
                    location.reload();
                },
                error:function(response) {
                    console.log(response);
                },
            });
        } 
    }
    function reactivarBusqueda(id) {
            $.ajax({
                type:'POST',
                url:'reactivar_registro.php',
                data:{'id':id},
                success:function(response){
                    console.log(response);
                    console.log("se cargo bien");
                    location.reload();
                },
                error:function(response) {
                   console.log(response);
                },
            });
    }
    $(function() {
        $("[data-toggle=tooltip]").tooltip();
    });

    function CallPrint(strid) {
        var prtContent = document.getElementById("print");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
    $(document).ready(function() {
       //load google map
       initialize();
    //    var PostCodeid = '#search_location';
       var PostCodeid = '#search_addr';

       var address = $(PostCodeid).val();
        geocoder.geocode({'address': address}, function (results, status) {
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
        // e.preventDefault();



        google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('.search_addr').val(results[0].formatted_address);
                    $('.search_latitude').val(marker.getPosition().lat());
                    $('.search_longitude').val(marker.getPosition().lng());
                }
            }
            });
        });
    });
    </script>
</body>

</html>