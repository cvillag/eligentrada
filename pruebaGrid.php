<?php include("header.php") ?>
<link rel="stylesheet" type="text/css" href="css/grid.css">
<div id="cont1">
<?php

echo '<nav id="navG">';
	include_once 'bd/tipoEventoDAO.php';
	include_once 'class/tipoEvento.php';
 	include_once 'bd/eventoDAO.php';
  	$arr = TipoEventoDAO::getTiposEvento();
  	echo '<h2 class="c1">Navegación</h2>';
  	$i;$j;
  	for($i = 0; $i < sizeof($arr); $i++){
		echo '<h3 class="c2">'.$arr[$i]->getNombreTipo().'</h3><div class="linea"></div><ul class="lista">';
		for($j=$i+1; $j < $i+3; $j++){
			echo'<li class="c3"><a href="evento.php">'.EventoDAO::getEventoById($j)->getNombreEvento().'</a></li>';
		}
		echo '</ul>';
  	}
  	echo '</nav>';
?>

<?php if(isset($_SESSION['nombre'])){?>
	<div class="main1 page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12" posicion-sm="1">
			<form  method="post"> 
				<input type="text" name="busqueda" value="Madrid" />
				<input class="boton2" type="submit" name="enviar" value="buscar"/>
			</form>
		</div>
			<div class="grid-xs-12 grid-md-3 grid-sm-6" id="colPoster" posicion-sm="3">
				<div class="cartelWrapper"><div id="cartel"><img id="cartel_ev" src="img/Rosendo.png" alt="concierto"/></div></div>
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
					<input type="hidden" name="imagen" value=""\>
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
							<input id="address" class="inputFull" type="text" name="lugar"  onchange="codeAddress()"/>
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

					<div class="fullRow">
							Tipo de evento
					</div>
					
					<div class="fullRow">
							<input type="radio" name="tipo" value="Concierto" checked>Concierto
							<input type="radio" name="tipo" value="Festival">Festival
							<input type="radio" name="tipo" value="Cine">Cine
							<input type="radio" name="tipo" value="Teatro">Teatro
					</div>
					<div class="linea"></div>
					<div class="fullRow">
						Entradas
					</div>
					<div class="row">
						<div class="celdaDef">Tipo</div>
						<div class="celdaVal">Precio</div>
					</div>
					<div class="row">
						<div class="celdaDef" id="tipoEn">
							VIP
						</div>
						<div class="celdaVal">
							<input type="number" name="numEnt"  />
						</div>
					</div>
					<div class="row">
						<div class="celdaDef" id="tipoEn">
							NORMAL
						</div>
						<div class="celdaVal">
							<input type="number" name="numEnt"  />
						</div>
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
	</div> <!-- main -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDunSLeIGsnRKjCW_Sx5nWh08RgOW3CMAE"></script>
<script type="text/javascript" src="scripts/geocoderinput.js"></script>
<script type="text/javascript" src="scripts/crear_evento.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		if($(window).width()<992){
			var listaDiv = $('div[posicion-sm]');
			listaDiv.sort(function(a,b){
				return $(a).attr('posicion-sm') - $(b).attr('posicion-sm');
			});
			$('.page-wrapper').html(listaDiv);
		}
		if($(window).width()<768){
			$('#navG').css('position', 'absolute');
			$('#navG').css('z-index', '1');
			$('#navG').css('left', '-260px');
			$("#logo").attr("src","img/logo-small.png");

			$('header').prepend('<button type=\"button\" class=\"navbar-toggle\" id=\"expandMenu\""><span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button>');

			$('#expandMenu').click(function(){
				var io = this.io ^= 1;
				$('#navG').animate({ left: io ? 0 : -260 }, 'slow');
			})
		};
	});

</script>
<?php } else {	?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>