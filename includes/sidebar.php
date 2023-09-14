<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">

        <li class="ts-label">Menu</li>
        <?PHP if(isset($_SESSION['id']))
				{ ?>
        <li><a href="dashboard.php"><i class="fa fa-desktop"></i>Seleccione una opción</a></li>

        <li><a href="book.php"><i class="fa fa-file-o"></i>Reportar vandalismo</a></li>
        <li><a href="vandalismo-detail.php"><i class="fa fa-file-o"></i>Ver Reporte</a></li>

        <li><a href="logout.php"><i class="fa fa-sign-out"></i>Salir</a></li>
        <?php 
				$userId=$_SESSION['id'];
				$ret="select * from notification where (iduser=?)";
				$stmt= $mysqli->prepare($ret) ;
				$stmt->bind_param('i',$userId);
				$stmt->execute() ;
				$res=$stmt->get_result();
				$cnt=0;
				while($row=$res->fetch_object())
					  {
						$cnt=$cnt+1;
					  }
				?>
        <!-- <li><a href="notification.php"><i class="fa fa-bell"></i>Notification<span
                    class="badge text-bg-secondary"><?php echo $cnt; ?></span></a></li> -->
        <?php } else { ?>

        <li><a href="registration.php"><i class="fa fa-files-o"></i> Registro Nuevo Usuario</a></li>
        <li><a href="index.php"><i class="fa fa-users"></i> Ingresar como Usuario</a></li>
        <li><a href="admin"><i class="fa fa-user"></i> Ingresar como Administrador</a></li>
        <?php } ?>

    </ul>
</nav>