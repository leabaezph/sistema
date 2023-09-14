<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
			
				<li class="ts-label">Admin</li>
				
				<li><a href="access-log.php"><i class="fa fa-file"></i>Log de acceso de usuarios</a></li>
				<li><a href="vandalismo-detail.php"><i class="fa fa-file"></i>Vandalismos registrados</a></li>
				<?php 
				$ret="select * from notification ";
				$stmt= $mysqli->prepare($ret) ;
				$stmt->execute() ;
				$res=$stmt->get_result();
				$cnt=0;
				while($row=$res->fetch_object())
					  {
						$cnt=$cnt+1;
					  }
				?>
				<!-- <li><a href="notification.php"><i class="fa fa-bell"></i>Notificaciones<span class="badge text-bg-secondary"><?php echo $cnt; ?></span></a></li> -->
				<li><a href="notification.php"><i class="fa fa-bell"></i>Auditoría<span class="badge text-bg-secondary"></span></a></li>
				<li><a href="logout.php"><i class="fa fa-sign-out"></i>Salir</a></li>

			
		</nav>