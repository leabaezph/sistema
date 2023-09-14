
<?php 
if(! empty($_SESSION['id']))
{ ?><div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px; color:#fff">Sistema de denuncias de vandalismo</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<!-- <button type="button" class="btn btn-primary justify-content-end">
  Notifications <span class="badge text-bg-secondary">4</span>
</button> -->

		<!-- <ul class="ts-profile-nav">

			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Cuenta <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="my-profile.php">Mi cuenta</a></li>
					<li><a href="logout.php">Salir</a></li>
				</ul>
			</li>

		</ul> -->
		
	</div>

<?php
} else { ?>
<div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px;">Sistema de denuncias de vandalismo</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>

		<ul class="ts-profile-nav">

			<li class="ts-account">
				<a href="#"> Ingreso <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<!-- <li><a href="my-profile.php">Mi cuenta</a></li>
					<li><a href="logout.php">Salir</a></li> -->
					<li><a href="registration.php"><i class="fa fa-files-o"></i> Registro Nuevo Usuario</a></li>
        <li><a href="index.php"><i class="fa fa-users"></i> Ingresar como Usuario</a></li>
        <li><a href="admin"><i class="fa fa-user"></i> Ingresar como Administrador</a></li>
				</ul>
			</li>

		</ul>

	</div>
	<?php } ?>