<?php include("header.php");
include ('bd/tipoEntradaDAO.php');
include_once ('class/tipoEntrada.php'); ?>

<div id="contenido">
		<?php include("nav.php") ?>
<?php if(isset($_SESSION['nombre'])){?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12" posicion-sm="1">
			<?php include('searchForm.php');?>
		</div>

		<div class="grid-xs-12 grid-md-3 grid-sm-6" id="colPoster" posicion-sm="3">
			<div id="cartel"><img id="cartel_ev" src="img/camera.png" alt="concierto"/></div>
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
					    <li id="errorUpload"></li>
				    </ul>
				</form>
			</div>
		</div>
		
		<div class="grid-xs-12 grid-md-6 grid-sm-12" id="formEvento" posicion-sm="2">
			<form method="post" name="form_ev">
				<input type="hidden" name="imagen" value="img/camera.png"\>
				<input type="hidden" name="ubicacionLatLong" value="" \> 
				<div class="formulario" id="formEv">
					<div class="row">
						<div class="celdaDef pequena">
							Nombre del evento
						</div>
						<div class="celdaVal grande">
							<input type="text" class="inputFull" name="nombre"  />
						</div>
					</div>
					<div class="row">
						<div class="celdaDef pequena">
							Lugar:
						</div>
						<div class="celdaVal grande">
							<input id="address" class="inputLugar" type="text" name="lugar"/>
							<span class="spanButton" onclick="codeAddress()">Buscar</span>
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena">
							Fecha:
						</div>
						<div class="celdaVal grande">
							<input type="date" name="fecha"  />
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena">
							Hora:
						</div>
						<div class="celdaVal grande">
							<input type="time" name="hora"  />
						</div>
					</div>
					
					<div class="row">
						<div class="celdaDef pequena" style="vertical-align: top">
							Descripción
						</div>
						<div class="celdaVal grande">
							<textarea name="descripcion" class="inputFull" rows="6" >
							</textarea>
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
									echo '<input id="pru'.$i.'" type="radio" name="tipo" value="'.$arr[$i]->getNombreTipo().'"><label for="pru'.$i.'"><span></span>'.$arr[$i]->getNombreTipo().'</label><br>';
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
					<div class="row" id="row1">
						<div class="celdaDef" id="tipoEn">
							<select name="tipo1" id="sel">

								<?php
									$arr = TipoEntradaDAO::getTiposEntrada();
									$i;
									for($i = 0; $i < sizeof($arr); $i++){
										echo '<option value="'.$arr[$i]->getNombre().'">'.$arr[$i]->getNombre().'</option>';
									}
								?>
							</select>
						</div>
						<div class="celdaMed">
							<input type="text" name="nombreEntrada1"  />
						</div>
						<div class="celdaVal peq">
							<input type="number" name="precEn1"  />
						</div>
						<div class="celdaCan peq">
							<input type="number" name="cantEn1" />
						</div>
					</div>
					<div class="row" id="row2">
						<div class="celdaDef" id="tipoEn">
							<select name="tipo2">
								<?php
									include_once 'bd/tipoEntradaDAO.php';
									include_once 'class/tipoEentrada.php';
									
									$arr = TipoEntradaDAO::getTiposEntrada();
									$i;
									for($i = 0; $i < sizeof($arr); $i++){
										echo '<option value="'.$arr[$i]->getNombre().'">'.$arr[$i]->getNombre().'</option>';
									}
								?>
							</select>
						</div>
						<div class="celdaMed">
							<input type="text" name="nombreEntrada2"  />
						</div>
						<div class="celdaVal peq">
							<input type="number" name="precEn2"  />
						</div>
						<div class="celdaCan peq">
							<input type="number" name="cantEn2" />
						</div>
					</div>

					<div id="plus" >
						<img src="img/plus.png">
					</div>
					<div id="delete" >
						<img src="img/delete.png ">
					</div>
					
					<div class="row err" id="passwd_error"></div>
					<div class="fullRow">	
						<a class="boton3" href="" id="guardar">Guardar Evento</a>
						<a class="boton3" href="gestionar_eventos.php">Salir sin guardar</a>
					</div>
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
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDunSLeIGsnRKjCW_Sx5nWh08RgOW3CMAE"></script>
<script type="text/javascript" src="scripts/geocoderInput.js"></script>
<script type="text/javascript" src="scripts/crear_evento.js"></script>
<?php } else {	?>
	<div class="page-wrapper">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>