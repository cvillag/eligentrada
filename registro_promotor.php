<?php include("header.php") ?>

<div id="contenido">
	<?php include("nav.php") ?>

	<div class="page-wrapper">
		<form method="post">
			<div id="formReg" class="grid-xs-12 grid-md-6 grid-sm-12">
				<div class="formulario">
					<div class="tituloForm">
						Registro para Promotor
					</div>
					<div class="row">
						<div class="celdaDef">Nombre*:</div>
						<div class="celdaVal"><input class="" type="text" name="nombre" required /></div>
					</div>
					<div  class="row">
						<div class="celdaDef">Correo*:</div>
						<div class="celdaVal"><input type="mail" name="Correo" required /></div>
						<!--Repetir Contraseña*: <input type="password" name="nombre" value="Contraseña" required/><br><br>-->
					</div>
					<div  class="row">
						<div class="celdaDef">Contraseña*:</div>
						<div class="celdaVal"><input type="password" name="password" required /></div>
					</div>
					<div  class="row">
						<div class="celdaDef">Repetir contraseña*:</div>
						<div class="celdaVal"><input type="password" name="passCheck" required /></div>
					</div>

					<div  class="row">
						<div class="celdaDef">CIF*:</div>
						<div class="celdaVal"><input type="text" name="cif" required /></div>
					</div>
					<div  class="row">
						<div class="celdaDef">Dirección:</div>
						<div class="celdaVal"><input type="text" name="direccion" /></div>
					</div>
					<div  class="row">
						<div class="celdaDef">Telefono:</div>
						<div class="celdaVal"><input type="number" name="telefono" /></div>
					</div>
					<div class="row err" id="passwd_error"></div>
					<div class="pieForm">
						<p class="nota_peq"> *Los campos con asterisco son obligatorios.</p>
					<p><a class="boton3" id="reg_prom" href="">Registrarse</a></p>
					</div>
					<div>
					<a href="registro_usuario.php" class="nota"> ¿Quieres registrarte como usuario? Pincha aqui</a>
				</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="scripts/registro_promotor.js"></script>
<?php include("footer.html") ?>