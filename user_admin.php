<?php
	include("header.php");
	include_once 'bd/usuarioDAO.php';
	
	/*
	 * Esta página tiene varios divs principales, de los cuales solo se muestran simultáneamente dos.
	 * 1. El primero es id=nav_misentradas, el cual contiene tres botones, cada uno para mostrar una sección concreta.
	 * 	Este siempre se muestra para poder ir de una vista a otra.
	 * 
	 * 2.Dentro de id=cont_misentradas se encuentra el resto de divs de contenido:
	 * 
	 * 	2.1 id=listaPromotores contiene la lista paginada de usuarios promotores. Directamente visualizable.
	 * 
	 *	2.2 id=listaClientes contiene la lista paginada de usuarios clientes. Directamente visualizable.
	 *
	 *	2.3 id=listaBusqueda contiene la lista paginada de usuarios tras la búsqueda. Para visualizarla se ha de realizar
	 *		una búsqueda.
	 *
	 *	3. Formularios. Cada uno tiene un div independiente.
	 *
	 *	3.1 id=formRegAdmin muestra los datos de un usuario seleccionado en cualquiera de las listas 2.1, 2.3 y 2.3
	 *		Permite su modificación.
	 *
	 *	3.2 id=formBusquedaUsuario, no muestra los datos concretos de un usuario, sino el formulario de búsqueda. De esta
	 *		forma se mantienen los datos de una búsqueda mientras se navega por las páginas de usuarios de dicha búsqueda
	 *		pudiendo acceder a los datos de los usuarios mediante 3.1, y modificando los datos de la propia búsqueda para
	 *		obtener una lista nueva  en 2.3.
	 * 
	 * Las ventaja de la paginación es estar en un punto intermedio entre la  carga masiva de usuarios en la página, que
	 * puede ralentizar la conexión si son  miles de usuarios, y la carga individual, que implica múltiples conexiones.
	 */
?>

<div id="contenido">
	<?php include("nav.php") ?>
<?php
	$tam_pag = 5;
	if(isset($_SESSION['nombre']) && $_SESSION["rol"] == 4){
		$us_cli = UsuarioDAO::getUsersByRol(6,0,$tam_pag);
		$us_prom = UsuarioDAO::getUsersByRol(5,0,$tam_pag);
		$num_p = UsuarioDAO::getNumUsersByRol(5);
		$num_c = UsuarioDAO::getNumUsersByRol(6);
		$max_pag_c = $num_c / $tam_pag ;
		$max_pag_p = $num_p / $tam_pag ;
		$pag_p=0;
		$pag_c=0;
	?>	
	<div class="page-wrapper">
	<?php 
		/*
		 * Los campos hidden se usan para almacenar información entre diferentes cargas ajax.
		 * tamPagUsers: tamaño de cada página. Es dinámico, pese a ser un valor fijo arriba. Con un simple cambio
		 * 				en el código se actualiza. Un cambio posible sería permitir elegir este tamaño, siendo rápido
		 * 				de  implementar gracias a esto.
		 */
	?>
		
		<input type="hidden" name="tamPagUsers" id="tamPagUsers" value="<?php echo $tam_pag?>">

		<?php 
		/*
		 * Botones para cambiar la vista: listas de usuarios y formularios de usuarios.
		 */
		?>
		<div id="nav_misentradas" class="grid-xs-12 grid-md-2 grid-sm-12">
			<div class="boton2" id="promsMain"><a href="#promotores">Promotores&nbsp;</a></div>
			<div class="boton2" id="usersMain"><a href="#usuarios">Usuarios&nbsp;</a></div>
			<div class="boton2" id="searchMain"><a href="#buscar">Buscar&nbsp;</a></div>
			<input type="hidden" id="cliPromSelect" value="cli">
		</div>
		<?php 
		/*
		 * Vista de usuarios promotores.Se indica el estado de la paginación  (página, inicio de página, fin de página)
		 * así como el número total de usuarios del tipo.
		 * Más abajo  hay una lista de campos  hidden, guardando toda la información de usuarios no visible. Ahorra
		 * cargas ajax, siendo accesibles los usuarios de la misma página actual (5 por defecto). Por otro lado, dado 
		 * el caso de llegar a miles de usuarios, la carga se hace más ágil.
		 */
		?>
		<div class="cont_misentradas grid-xs-12 grid-md-7 grid-sm-12" id="control">
			<div class="titulo_evento"><h2 id="tituloListaUsuarios">Clientes registrados</h2></div>
			<div id="listaPromotores">
				<h3 class="c2">
					Promotores&nbsp;
					<img alt="Primeros" src="img/first.gif" id="primeraPagUsProm">
					<img alt="Anterior" src="img/prev.gif" id="antPagUsProm">
					Mostrando 
					<span id="numRel_p"><?php echo ($pag_p*$tam_pag)+1 ?></span>
					..
					<span id="numRelFin_p"><?php if($pag_p*$tam_pag+$tam_pag < count($us_prom))echo $pag_p*$tam_pag+$tam_pag;else echo count($us_prom); ?></span>
					de 
					<span id="numTot_p"><?php echo $num_p ?></span>
					<img alt="Siguiente" src="img/next.gif" id="sigPagUsProm">
					<img alt="Últimos" src="img/last.gif" id="ultPagUsProm">
				</h3>
				<input type="hidden" name="pag_prom" id="pag_prom" value="<?php echo $pag_p; ?>">
				<input type="hidden" name="num_tot_prom" id="num_tot_prom" value="<?php echo  $num_p;?>">
				<input type="hidden" name="maxPagProm" id="maxPagProm" value="<?php echo $max_pag_p?>">
				<div class="linea"></div>
					<ul class="lista">
			<?php
				$cont = 0;		
				foreach ($us_prom as $userp){
			?>		
						<li class="c3 user_select" id="nameUsPromBox<?php echo $cont?>"><span id="nameUsProm<?php echo $cont?>"><?php echo $userp->getNombre()?>&nbsp;<?php echo $userp->getApellidos()?></span>
						<input  type="hidden" id="idUsProm<?php echo $cont?>" name="idUsProm<?php echo $cont?>" value="<?php echo $userp->getIdUsuario()?>">
						<input  type="hidden" id="nombreProm<?php echo $cont?>" name="nombreProm<?php echo $cont?>" value="<?php echo $userp->getNombre()?>">
						<input  type="hidden" id="apellidosProm<?php echo $cont?>" name="apellidosProm<?php echo $cont?>" value="<?php echo $userp->getApellidos()?>">
						<input  type="hidden" id="correoProm<?php echo $cont?>" name="correoProm<?php echo $cont?>" value="<?php echo $userp->getCorreo()?>">
						<input  type="hidden" id="dniProm<?php echo $cont?>" name="dniProm<?php echo $cont?>" value="<?php echo $userp->getDni()?>">
						<input  type="hidden" id="cifProm<?php echo $cont?>" name="cifProm<?php echo $cont?>" value="<?php echo $userp->getCif()?>">
						<input  type="hidden" id="direccionProm<?php echo $cont?>" name="direccionProm<?php echo $cont?>" value="<?php echo $userp->getDireccion()?>">
						<input  type="hidden" id="telefonoProm<?php echo $cont?>" name="telefonoProm<?php echo $cont?>" value="<?php echo $userp->getTelefono()?>">
						</li>
				<?php
					$cont++; 
					}?>
					</ul>
			</div>
			<?php 
			/*
			 * Vista de lista de clientes. Mismo funcionamiento que la de promotores.
			 */
			?>
			<div id="listaClientes">
				<h3 class="c2">
					Usuarios&nbsp; 
					<img alt="Primeros" src="img/first.gif" id="primeraPagUsCli">
					<img alt="Anterior" src="img/prev.gif" id="antPagUsCli">
					Mostrando 
					<span id="numRel_c"><?php echo ($pag_c*$tam_pag)+1 ?></span>
					..
					<span id="numRelFin_c"><?php if($pag_c*$tam_pag+$tam_pag < count($us_cli))echo $pag_c*$tam_pag+$tam_pag;else echo count($us_cli); ?></span>
					de
					<span id="numTot_c"><?php echo $num_c ?></span>
					<img alt="Siguiente" src="img/next.gif" id="sigPagUsCli">
					<img alt="Últimos" src="img/last.gif" id="ultPagUsCli">
				</h3>
				<input type="hidden" name="pag_cli" id="pag_cli" value="<?php echo $pag_c; ?>">
				<input type="hidden" name="num_tot_cli" id="num_tot_cli" value="<?php echo  $num_c;?>">
				<input type="hidden" name="maxPagCli" id="maxPagCli" value="<?php echo $max_pag_c?>">
				<div class="linea"></div>
				<ul class="lista">

				<?php
					$cont = 0;
					foreach ($us_cli as $user){
						
				?>
						<li class="c3 user_select" id="nameUsCliBox<?php echo $cont?>"><span id="nameUsCli<?php echo $cont?>"><?php echo $user->getNombre()?>&nbsp;<?php echo $user->getApellidos()?></span>
						<input  type="hidden" id="idUsCli<?php echo $cont?>" name="idUsCli<?php echo $cont?>" value="<?php echo $user->getIdUsuario()?>">
						<input  type="hidden" id="nombreCli<?php echo $cont?>" name="nombreCli<?php echo $cont?>" value="<?php echo $user->getNombre()?>">
						<input  type="hidden" id="apellidosCli<?php echo $cont?>" name="apellidosCli<?php echo $cont?>" value="<?php echo $user->getApellidos()?>">
						<input  type="hidden" id="correoCli<?php echo $cont?>" name="correoCli<?php echo $cont?>" value="<?php echo $user->getCorreo()?>">
						<input  type="hidden" id="dniCli<?php echo $cont?>" name="dniCli<?php echo $cont?>" value="<?php echo $user->getDni()?>">
						<input  type="hidden" id="cifCli<?php echo $cont?>" name="cifCli<?php echo $cont?>" value="<?php echo $user->getCif()?>">
						<input  type="hidden" id="direccionCli<?php echo $cont?>" name="direccionCli<?php echo $cont?>" value="<?php echo $user->getDireccion()?>">
						<input  type="hidden" id="telefonoCli<?php echo $cont?>" name="telefonoCli<?php echo $cont?>" value="<?php echo $user->getTelefono()?>">
						</li>
				<?php
					$cont++;
					}
				?>
				</ul>
			</div>
			<?php 
			/*
			 * Lista de clientes. Mismo funcionamiento que las anteriores, pese a ser diferente el jquery.
			 */
			?>
			<div id="listaBusqueda">
				<h3 class="c2">
					Resultado de la búsqueda&nbsp; 
					<img alt="Primeros" src="img/first.gif" id="primeraPagB">
					<img alt="Anterior" src="img/prev.gif" id="antPagB">
					Mostrando 
					<span id="numRel_b">1</span>
					..
					<span id="numRelFin_b">1</span>
					de
					<span id="numTot_b">1</span>
					<img alt="Siguiente" src="img/next.gif" id="sigPagB">
					<img alt="Últimos" src="img/last.gif" id="ultPagB">
				</h3>
				<input type="hidden" name="pag_b" id="pag_b" value="0">
				<input type="hidden" name="num_tot_b" id="num_tot_b" value="1">
				<input type="hidden" name="maxPagB" id="maxPagB" value="1">
				<div class="linea"></div>
				<ul class="lista">

				<?php
					for ($cont = 0; $cont < $tam_pag; $cont++){
						
				?>
						<li class="c3 user_select" id="nameUsBBox<?php echo $cont?>"><span id="nameUsB<?php echo $cont?>"></span>
						<input  type="hidden" id="idUsB<?php echo $cont?>" name="idUsB<?php echo $cont?>" value="">
						<input  type="hidden" id="nombreB<?php echo $cont?>" name="nombreB<?php echo $cont?>" value="">
						<input  type="hidden" id="apellidosB<?php echo $cont?>" name="apellidosB<?php echo $cont?>" value="">
						<input  type="hidden" id="correoB<?php echo $cont?>" name="correoB<?php echo $cont?>" value="">
						<input  type="hidden" id="dniB<?php echo $cont?>" name="dniB<?php echo $cont?>" value="">
						<input  type="hidden" id="cifB<?php echo $cont?>" name="cifB<?php echo $cont?>" value="">
						<input  type="hidden" id="direccionB<?php echo $cont?>" name="direccionB<?php echo $cont?>" value="">
						<input  type="hidden" id="telefonoB<?php echo $cont?>" name="telefonoB<?php echo $cont?>" value="">
						</li>
				<?php
					}
				?>
				</ul>
			</div>
			
		</div>
		<?php 
		/*
		 * Formulario de edición y consulta de datos de usuarios. Común para clientes y promotores, diferenciandose
		 * dinámicamente.
		 * Según se seleccione cada usuario de la lista, se modificará dinámicamente los campos del formulario,
		 * incluyendo el identificador oculto, que es el usado para modificar los  datos.
		 */
		?>
		<div id="formRegAdmin" class="cont_misentradas grid-xs-12 grid-md-7 grid-sm-12">
			<form method="post">
			<div class="formulario">
				<div class="tituloForm">
					<span id="tipoUsuario"></span>
				</div>
				<input  type="hidden" id="idUsuario" value="">
				<div class="row">
					<div class="celdaDef">Nuevo nombre:</div>
					<div class="celdaVal"><input class="" type="text" name="nombre" id="nombre" required  value="a"/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Apellidos:</div>
					<div class="celdaVal"><input class="" type="text" name="apellidos" id="apellidos" value=""/></div>
				</div>
				<div class="row" id="dniParticular">
					<div class="celdaDef">DNI:</div>	
					<div class="celdaVal"><input type="text" name="dni" id="dni" value=""/></div>
				</div>
				<div class="row" id="cifParticular">
					<div class="celdaDef">CIF:</div>	
					<div class="celdaVal"><input type="text" name="cif" id="cif" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Dirección:</div>
					<div class="celdaVal"><input class="" type="text" name="direccion" id="direccion" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Teléfono:</div>
					<div class="celdaVal"><input class="" type="text" name="telefono"  id="telefono" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Correo*:</div>
					<div class="celdaVal"><input type="email" name="correoReg" required id="correoReg" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Contraseña*:</div>
					<div class="celdaVal"><input type="password" name="password" required id="password" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Repita contraseña*:</div>
					<div class="celdaVal"><input type="password" name="passwordCheck" required id="passwordCheck" value=""/></div>
				</div>
				<div class="pieForm">
					<p><a class="boton3" id="updateDataAdmin" href="">Guardar cambios</a></p>
				</div>
				<div class="row err" id="passwd_error"></div>
			</div>
			</form>
		</div>
		<?php 
		/*
		 * Formulario de búsqueda tras una búsqueda. Como se comentó, este formulario permanece inalterado mientras se
		 * navega por 2.3 y 3.1. 
		 */
		?>
		<div id="formBusquedaUsuario" class="cont_misentradas grid-xs-12 grid-md-7 grid-sm-12">
			<form method="post">
			<div class="formulario">
				<div class="tituloForm">
					Búsqueda de usuarios
				</div>
				<div class="row">
					<div class="celdaDef">Nombre contiene:</div>
					<div class="celdaVal"><input class="" type="text" name="nombreBus" id="nombreBus" required /></div>
				</div>
				<div class="row">
					<div class="celdaDef">Apellidos contiene:</div>
					<div class="celdaVal"><input class="" type="text" name="apellidosBus" id="apellidosBus" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">DNI contiene:</div>	
					<div class="celdaVal"><input type="text" name="dniBus" id="dniBus" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">CIF contiene:</div>	
					<div class="celdaVal"><input type="text" name="cifBus" id="cifBus" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Dirección contiene:</div>
					<div class="celdaVal"><input class="" type="text" name="direccionBus" id="direccionBus" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Teléfono exacto:</div>
					<div class="celdaVal"><input class="" type="text" name="telefonoBus"  id="telefonoBus" value=""/></div>
				</div>
				<div class="row">
					<div class="celdaDef">Correo contiene:</div>	
					<div class="celdaVal"><input type="email" name="correoRegBus" id="correoRegBus" value=""/></div>
				</div>
				<div class="fullRow">
					Tipo de usuario:
				</div>
				<div class="row">
					<div class="celdaDef">
						<p id="checkCli"> Cliente </p>
					</div>
					<div class="celdaVal">
						<input id="radioCli" type="radio" name="tipoUser" value="6">
					</div>
				</div>
				<div class="row">
					<div class="celdaDef">
						<p id="checkProm"> Promotor</p>
					</div>
					<div class="celdaVal">
						<input id="radioProm" type="radio" name="tipoUser" value="5">
					</div>
				</div>
				<div class="row">
					<div class="celdaDef">
						<p id="checkInd"> Cualquiera</p>
					</div>
					<div class="celdaVal">
						<input id="radioInd" type="radio" name="tipoUser" value="0" checked="checked">
					</div>
				</div>
				<div class="pieForm">
					<p><a class="boton3" id="findUsers" >Buscar</a></p>
				</div>
				<div class="fullRow" id="mensaje_busq"></div>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="scripts/gest_usuarios.js"></script>
<script type="text/javascript" src="scripts/actualizarDatosUsuario.js"></script>
<?php } else {	?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
<?php }?>
<?php include("footer.html") ?>