<?php 
if(!isset($_SESSION['nombre'])){ ?>

	<form  method="post" action="" id="formLogin">
		<div class="formulario">
			<div class="row">
				<div class="celdaDef">E-mail: </div>
				<div class="celdaVal"> <input type="email" name="correo" id="correo" required/></div>
			</div>
			<div class="row">
				<div class="celdaDef">Contraseña: </div>
				<div class="celdaVal"><input type="password" name="pass" id="pass" required/></div>
			</div>
			<div class="err fullRow" id="login_error"></div>
			<div class="fullRow">
				<button id="login_entrar" class="boton2" type="submit">Entrar</button>
			</div>
			<div class="nota_peq">
				<a href="registro_usuario.php" class="boton2"> ¿No estas registrado?</a>
			</div>
		</div>
	</form>
<?php 
} elseif (isset($_SESSION['nombre']) && $_SESSION['rol'] == 4) { ?>
	<div class="formulario">
		<ul id="userMenu">
			<li><a href="datos_usuario.php"> Perfil</a></li>
			<li><a href="user_admin.php"> Gestionar Usuarios</a></li>
			<li><a href="categoria_eventos.php"> Categorias Eventos</a></li>
			<li><a href="tipos_entrada.php"> Tipos de Entrada</a></li>
			<li><button id="logout" class="boton2">Desconectarse</button></li>
		</ul>
	</div>
	
<?php
} elseif (isset($_SESSION['nombre']) && $_SESSION['rol'] == 5) {  ?>
	<div class="formulario">
		<ul id="userMenu">
			<li><a href="datos_usuario.php"> Perfil</a></li>
			<li><a href="crear_evento.php"> Crear evento</a></li>
			<li><a href="gestionar_eventos.php"> Gestionar eventos</a></li>
			<li><button id="logout" class="boton2">Desconectarse</button></li>
		</ul>
	</div>

<?php
} elseif (isset($_SESSION['nombre']) && $_SESSION['rol'] == 6) {  ?>
	<div class="formulario">
		<ul id="userMenu">
			<li><a href="datos_usuario.php"> Perfil </a></li>
			<li><a href="mis_entradas.php"> Mis entradas </a></li>
			<li><button id="logout" class="boton2">Desconectarse</button></li>
		</ul>
	</div>
	
<?php } ?>