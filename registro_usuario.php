<?php include("header.php") ?>

<div id="contenido">
	<?php include("nav.php") ?>

	<div class="page-wrapper">

		<div id="formReg" class="grid-xs-12 grid-md-6 grid-sm-12">
			<form method="post">
			<div class="formulario">
				<div class="tituloForm">
					Registro
				</div>
				<div class="row">
					<div class="celdaDef">Nombre*:</div>
					<div class="celdaVal"><input class="" type="text" name="nombre" required/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Apellidos:</div>
					<div class="celdaVal"><input class="" type="text" name="apellidos"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">DNI:</div>	
					<div class="celdaVal"><input type="text" name="dni"/></div>
				</div>
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
					<div class="celdaDef">Contraseña*:</div>
					<div class="celdaVal"><input type="password" name="password" required/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Repita contraseña*:</div>
					<div class="celdaVal"><input type="password" name="passwordCheck" required/></div>
				</div>
				<div class="row err" id="passwd_error"></div>
				<div class="pieForm">
					<p class="nota_peq"> *Los campos con asterisco son obligatorios.</p>
					<p><a class="boton3" id="registro"href="">Registrarse</a></p>
				</div>
				<div>
					<a href="registro_promotor.php" class="nota"> ¿Quieres registrarte como promotor? Pincha aqui</a>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="scripts/registro.js"></script>

<?php include("footer.html") ?>