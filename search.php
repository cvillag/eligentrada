<?php include ("header.php"); 	 	
include ('bd/eventoDAO.php'); 	 	
include ('bd/tipoEventoDAO.php'); 	 	
include ('bd/tipoEntradaEventoDAO.php');?>

<div id="contenido">
	<?php include("nav.php") ?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12">
			<form  method="post"> 
				<?php include('searchForm.php');?>
			</form>
		</div>
		
		<div id="nav_misentradas" class="grid-xs-12 grid-md-2 grid-sm-12">
			<div class="boton2"><a href="#actuales">Actuales</a></div>
			<div class="boton2"><a href="#pasados">Pasados</a></div>
		</div>
		
		<div id="resultadosBusqueda" class="grid-xs-12 grid-md-9 grid-sm-12">
			<div class="titulo_evento"><h2>Resultados de la búsqueda</h2></div>
			<?php 
				date_default_timezone_set('Europe/Madrid');
				if(isset($_REQUEST["q"])){
			?>
			<a name="actuales"/></a>
			<h3 class="c2">Actuales</h3>
			<div class="linea"></div>
			<ul class="lista">
			<?php
				$query = htmlspecialchars(trim(strip_tags($_REQUEST["q"])));
				//Se hacen varias solicitudes para mostrar primeros las coincidencias por nombre
				$eventosByName = eventoDAO::searchByName($query);
				$eventosByLocation = eventoDAO::searchByLocation($query);
				$eventosBusqueda = array_unique(array_merge($eventosByName, $eventosByLocation),SORT_REGULAR);
				$ahora = new DateTime();
				$ahora = $ahora->getTimestamp();
				setlocale(LC_TIME,"es_ES");
				$nEventos = 0;
				foreach ($eventosBusqueda as $evento) {
					$timestamp = strtotime($evento->getFecha());
					if($timestamp >= $ahora){
						$nEventos++;
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
								</div>
							</a>
						</li>';
					}
				}
				if($nEventos == 0){
					echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>Sin resultados</h3></div></div></li>';
				}
			?>
			</ul>
			<a name="pasados"/>
			<h3 class="c2">Pasados</h3>
			<div class="linea"></div>
			<ul class="lista">
			<?php
				$nEventos = 0; 
				foreach ($eventosBusqueda as $evento) {
					$timestamp = strtotime($evento->getFecha());
					if($timestamp < $ahora){
						$nEventos++;
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
								</div>
							</a>
						</li>';
					}
				}
				if($nEventos == 0) echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>Sin resultados</h3></div></div></li>';
			?>
			</ul>
					
			<?php
			} elseif (isset($_REQUEST["t"])){
			?>
			<a name="actuales"/></a>
			<h3 class="c2">Actuales</h3>
			<div class="linea"></div>
			<ul class="lista">
			<?php
				$query = htmlspecialchars(trim(strip_tags($_REQUEST["t"])));
				$eventosBusqueda = eventoDAO::searchByType($query);
				$ahora = new DateTime();
				$ahora = $ahora->getTimestamp();
				setlocale(LC_TIME,"es_ES");
				$nEventos = 0;
				foreach ($eventosBusqueda as $evento) {
					$timestamp = strtotime($evento->getFecha());
					if($timestamp >= $ahora){
						$nEventos++;
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
								</div>
							</a>
						</li>';
					}
				}
				if($nEventos == 0) echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>Sin resultados</h3></div></div></li>';
			?>
			</ul>
			<a name="pasados"/>
			<h3 class="c2">Pasados</h3>
			<div class="linea"></div>
			<ul class="lista">
			<?php 
				$nEventos = 0;
				foreach ($eventosBusqueda as $evento) {
					$timestamp = strtotime($evento->getFecha());
					if($timestamp < $ahora){
						$nEventos++;
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
								</div>
							</a>
						</li>';
					}
				} 
				if($nEventos == 0) echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>Sin resultados</h3></div></div></li>';
				?>
			</ul>
			<?php
				}
			?>
			
		</div>
	</div>
</div>

<?php include("footer.html") ?>