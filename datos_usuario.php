<?php include("header.php") ?>

<div id="contenido">
	<?php include("nav.php") ?>
<?php if(isset($_SESSION['nombre'])){?>
	<div class="page-wrapper">

		<div id="formReg">
			<form method="post" >
			<div class="formulario">
				<div class="tituloForm">
					Perfil
				</div>
				<div class="row">
					<div class="celdaDef">Nombre*:</div>
					<div class="celdaVal"><input class="" type="text" name="nombre" required/></div>
				</div>
				<?php if($_SESSION["rol"]!=5) 
					echo'
					<div class="row">
						<div class="celdaDef">Apellidos:</div>
						<div class="celdaVal"><input class="" type="text" name="apellidos"/></div>
					</div>'; 
				?>

				<?php if($_SESSION["rol"]==5) 
					echo'
					<div class="row">
						<div class="celdaDef">CIF:</div>	
						<div class="celdaVal"><input type="text" name="cif"/></div>
					</div>
					';
					else echo'
					<div class="row">
						<div class="celdaDef">DNI:</div>	
						<div class="celdaVal"><input type="text" name="dni"/></div>
					</div>
					';
				?>
				<div class="row">
					<div class="celdaDef">Dirección:</div>
					<div class="celdaVal"><input class="" type="text" name="direccion"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Teléfono:</div>
					<div class="celdaVal"><input class="" type="text" name="telefono"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Correo*:</div>	
					<div class="celdaVal"><input type="email" name="correoReg" required/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Contraseña actual:</div>
					<div class="celdaVal"><input type="password" name="currPass"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Contraseña nueva:</div>
					<div class="celdaVal"><input type="password" name="newPass"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Repita nueva contraseña:</div>
					<div class="celdaVal"><input type="password" name="newPassCheck"/></div>
				</div>
				<div class="row err" id="passwd_error"></div>
				<div class="pieForm">
					<p>
						<a class="boton3" id="updateData"href="">Actualizar</a>
						<a class="boton3" href="index.php">Cancelar</a>
					</p>
					
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="scripts/actualizarDatosUsuario.js"></script>
<?php }else {?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>