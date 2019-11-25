<?php include("header.php"); ?>
<div id="contenido">
	<?php include("nav.php");
		include_once 'bd/tipoEntradaEventoDAO.php';
		include_once 'class/tipoEntradaEvento.php';
	?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12" posicion-sm="1">
			<?php include('searchForm.php');?>
		</div>
<?php if(isset($_REQUEST['eid'])) $evento = EventoDAO::getEventoById($_REQUEST['eid']);
		if(!is_null($evento)){
?>
		<div class="grid-xs-12 grid-md-3 grid-sm-6" id="colPoster" posicion-sm="3">
	
		<div id="cartel"><img id="cartel_ev" src="<?php echo $evento->getRutaImagen()?>" alt="<?php echo $evento->getNombreEvento()?>"/></div>

			<h3>Dónde</h3>
			<div id="mapa">
				<div id="map-canvas"></div>
			</div>
		</div>

		<div class="grid-xs-12 grid-md-9 grid-sm-12" id="infoEvento" posicion-sm="2">
			<div class="col_izq">
				<input type="hidden" name="ubicacionLatLong" value="<?php echo $evento->getUbicacionLatLong()?>"\> 
				<div class="titulo_evento"><h1><?php echo $evento->getNombreEvento();?></h1></div>
				<table class="datos_evento">
					<tr>
						<td>Lugar: </td>
						<td><p id="address"><?php echo $evento->getLugar();?></p></td>
					</tr>
					<tr>
						<td>Fecha: </td>
						<td><?php echo $evento->getFecha();?></td>
					</tr>
					<tr>
						<td>Hora: </td>
						<td><?php echo $evento->getHora();?></td>
					</tr>
				</table>
				<h4 class="titulo_menor">Descripción</h4>
				<p id="descripcion">
					<?php echo $evento->getDescripcion();?>
				</p>
			</div>
			<div id="formEvento">
				<form class="form_precios" method="post">
					<?php echo '<input type="hidden" name="idEvento" value="'.$evento->getIdEvento().'">' ?>
					<div class="formulario">
						<div class="tituloForm">
							Entradas
						</div>
						<?php 
						date_default_timezone_set('Europe/Madrid');
						if(strtotime($evento->getFecha())>=strtotime(date("Y/m/d"))){
							if(isset($_SESSION['nombre'])){
								$entradas = tipoEntradaEventoDAO::getTiposEntradaEventoByIdEvento($evento->getIdEvento());
								foreach ($entradas as $entrada) {
									echo '
									<div class="row">
										<div class="celdaDef">'.$entrada->getNombreParticular().' ('.$entrada->getPrecio().'€)</div>
										<div class="celdaVal entrada">
											<input type="hidden" name="precio" value="'.$entrada->getPrecio().'">
											<input type="hidden" name="idEntrada" value="'.$entrada->getIdTipo().'">
											<input type="number" name="'.$entrada->getIdTipo().'" onchange="compute_total()" />
										</div>
									</div>
									<div class="row">
										<div class="celdaDef">Total</div>	
										<div class="celdaVal"><input type="number" id="total" name="total" value="" readonly="readonly"/></div>
									</div>
									<div class="pieForm">
										<a class="boton2" id="bt_buy">Comprar</a>
										<a class="boton2" href="index.php">Cancelar</a>
									</div>';
								}
							} else {
								echo '
									<div class=pieForm>
										<p>Por favor, regístrese o identifíquese en la página para poder comprar</p>
									</div>
								';
							}
						} else {
							echo '
									<div class=pieForm>
										<p>El evento ya ha terminado</p>
									</div>
								';
						}
						?>
						
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
	<div class="grid-xs-12 grid-md-12 grid-sm-12" posicion-sm="2">
		<h3>Evento no encontrado</h3>
	</div>
</div>
<?php	} ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDunSLeIGsnRKjCW_Sx5nWh08RgOW3CMAE"></script>
<script type="text/javascript" src="scripts/geocoder.js"></script>
<script type="text/javascript" src="scripts/compraScript.js"></script>
<?php include("footer.html") ?>
