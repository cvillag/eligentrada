<?php include ("header.php"); 	 	
include ('bd/eventoDAO.php'); 	 	
include ('bd/tipoEventoDAO.php'); 	 	
include ('bd/tipoEntradaEventoDAO.php');?>

<div id="contenido">
	<?php include("nav.php") ?>
<?php if(isset($_SESSION['nombre'])){	
$idEvento = htmlspecialchars(trim(strip_tags($_GET["evento"])));
$evento = eventoDAO::getEventoById($idEvento);
if(!is_null($evento)&&$_SESSION['id']==$evento->getIdPromotor()){
	$tipo = null;
	// if evento no existente error y volver
	$teventos = tipoEventoDAO::getTiposEvento();
		foreach ($teventos as $tevento) {
			if ($tevento->getIdTipo() == $evento->getTipo()) {
				$tipo = $tevento->getNombreTipo();
			}
		}

	$tentradas = tipoEntradaEventoDAO::getTiposEntradaEventoByIdEvento($idEvento);

?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12" posicion-sm="1">
			<?php include('searchForm.php');?>
		</div>

		<div class="grid-xs-12 grid-md-3 grid-sm-6" id="colPoster" posicion-sm="3">
			<div id="cartel"><img id="cartel_ev" src="<?php echo $evento->getRutaImagen()?>" alt="<?php echo $evento->getNombreEvento()?>"/></div>
			<div id="uploadForm">
				<form id="fileUpload" action="upload.php" method="post" enctype="multipart/form-data">
					<ul>
					    <li>
					    	<span class="fileinput-button boton2">
						    	Selecciona Imagen
						    	<input type="file" name="fileToUpload" id="fileToUpload">
					    	</span>
						</li>
					    <li><input type="submit" class="boton2" value="Subir imagen" name="submit"></li>
				    </ul>
				</form>
			</div>
		</div>
		
		<div class="grid-xs-12 grid-md-6 grid-sm-12" id="formEvento" posicion-sm="2">
			<form method="post" name="form_ev">
				<input type="hidden" name="idEvento" value=<?php echo '"'.$_GET["evento"].'"';?>\>
				<input type="hidden" name="imagen" value="<?php echo $evento->getRutaImagen()?>"\>
				<input type="hidden" name="ubicacionLatLong" value="<?php echo $evento->getUbicacionLatLong()?>"\> 
				<div class="formulario" id="formEv">
					<div class="row">
						<div class="celdaDef pequena">
							Nombre del evento
						</div>
						<div class="celdaVal grande">
							<input type="text" class="inputFull" name="nombre" value=<?php echo '"'.$evento->getNombreEvento().'"';?> />
						</div>
					</div>
					<div class="row">
						<div class="celdaDef pequena">
							Lugar:
						</div>
						<div class="celdaVal grande">
							<input id="address" class="inputLugar" type="text" name="lugar" value=<?php echo '"'.$evento->getLugar().'"';?>/>
							<span class="spanButton" onclick="codeAddress()">Buscar</span>
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena">
							Fecha:
						</div>
						<div class="celdaVal grande">
							<input type="date" name="fecha" value=<?php echo '"'.$evento->getFecha().'"';?>/>
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena">
							Hora:
						</div>
						<div class="celdaVal grande">
							<input type="time" name="hora" value=<?php echo '"'.$evento->getHora().'"';?> />
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena" style="vertical-align: top">
							Descripción
						</div>
						<div class="celdaVal grande">
							<textarea name="descripcion" class="inputFull" rows="6" ><?php echo $evento->getDescripcion(); ?></textarea>
						</div>
					</div>

					<div class="row">
						<div class="celdaDef pequena">
							Tipo de evento
						</div>
						
						<div class="celdaVal grande">
							<?php
								$arr = TipoEventoDAO::getTiposEvento();
								$i;
								for($i = 0; $i < sizeof($arr); $i++){
									echo '<input id="pru'.$i.'" type="radio" name="tipo" value="'.$arr[$i]->getNombreTipo().'"';
									if($tipo == $arr[$i]->getNombreTipo()){echo 'checked';}
									echo '><label for="pru'.$i.'"><span></span>'.$arr[$i]->getNombreTipo().'</label><br>';
								}
							?>
						</div>
					</div>
					<div class="linea"></div>
					<div class="fullRow">
						Entradas
					</div>
					<div class="row">
						<div class="celdaDef">Tipo</div>
						<div class="celdaMed">Nombre</div>
						<div class="celdaVal">Precio</div>
						<div class="celdaCan">Cantidad</div>
					</div>

					<?php
						$k = 1;
						include_once 'bd/tipoEntradaDAO.php';
						include_once 'class/tipoEntrada.php';
						$arr = tipoEntradaDAO::getTiposEntrada();
						foreach ($tentradas as $tentrada) {
							echo'<div class="row" id="row'.$k.'">';
							echo'<div class="celdaDef" id="tipoEn"> <select name="tipo'.$k.'">';
							$i;
							for($i = 0; $i < sizeof($arr); $i++){
								echo '<option value="'.$arr[$i]->getNombre().'"';
								if($arr[$i]->getIdTipo() == $tentrada->getIdTipo()){
									echo'selected';
								}
								echo '>'.$arr[$i]->getNombre().'</option>';
							}

							echo'</select> </div>';
							echo'<div class="celdaMed"> <input type="text" name="nombreEntrada'.$k.'" value ="'.$tentrada->getNombreParticular().'" /> </div>';
							echo'<div class="celdaVal peq"> <input type="number" name="precEn'.$k.'" value ="'.$tentrada->getPrecio().'" /> </div>';
							echo'<div class="celdaCan peq"> <input type="number" name="cantEn'.$k.'" value ="'.$tentrada->getCantidad().'" /> </div>';
							echo'</div>';
							$k++;
						}
					?>

					<!--<div id="plus" >
						<img src="img/plus.png">
					</div>
					<div id="delete" >
						<img src="img/delete.png ">
					</div>-->
					
					<div class="row err" id="passwd_error"></div>
					<div class="fullRow bot">	
						<a class="boton3" href="" id="guardar">Guardar Evento</a>
						<a class="boton3" href="gestionar_eventos.php">Salir sin guardar</a>
					</div>

					<div class="linea"></div>
					<div class="fullRow">
						Entradas Vendidas
					</div>
					<table id="entradasVendidas">
						<tr>
							<th>Tipo</th>
							<th>Nombre</th>
							<th>Cantidad</th>
						</tr>
					<?php 
						include_once 'bd/compraDAO.php';
						foreach ($tentradas as $entrada) {	
						
						echo '<tr>';		
							$vendidas = compraDAO::getEntradasVendidas($idEvento, $entrada->getIdTipo());
							echo '
								<td>'.tipoEntradaDAO::getTipoEntradaById($entrada->getIdTipo())->getNombre().'</td>
								<td>'.$entrada->getNombreParticular().'</td>
								<td>'.$vendidas.'</td>';
						echo '</tr>';
						}
					?>
					</table>
				</div>
			</form>
		</div>
		<div class="grid-xs-12 grid-xl-3 grid-md-3 grid-sm-6" id="mapEvento" posicion-sm="4">
			<h3>Dónde</h3>
			<div id="mapa">
				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
	<?php }?>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDunSLeIGsnRKjCW_Sx5nWh08RgOW3CMAE"></script>
<script type="text/javascript" src="scripts/geocoderInput.js"></script>
<script type="text/javascript" src="scripts/mod_evento.js"></script>
<?php } else {	?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>