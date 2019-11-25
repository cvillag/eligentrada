<?php include("header.php");
	include_once 'bd/compraDAO.php';
	include_once 'bd/eventoDAO.php';
	include_once 'bd/tipoEventoDAO.php';
	include_once 'bd/tipoEntradaEventoDAO.php';
	include_once 'class/compra.php';
 ?>

<div id="contenido">
	<?php include("nav.php") ?>
<?php if(isset($_SESSION['nombre'])){?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12">
			<?php include('searchForm.php');?>
		</div>

		<div id="nav_misentradas" class="grid-xs-12 grid-md-2 grid-sm-12">
			<div class="boton2"><a href="#actuales">Actuales</a></div>
			<div class="boton2"><a href="#pasados">Pasados</a></div>
		</div>
		<div id="cont_misentradas" class="grid-xs-12 grid-md-10 grid-sm-12">
		<div class="titulo_evento"><h2>Mis entradas</h2></div>
		<a name="actuales"/>
		<h3 class="c2">Actuales</h3>
		<div class="linea"></div>
			<ul class="lista">
			<?php 
				date_default_timezone_set('Europe/Madrid');
				setlocale(LC_TIME,"es_ES");
				function cmp($a, $b){
					    return strtotime(eventoDAO::getEventoById($a->getIdEvento())->getFecha()) - 
					    	strtotime(eventoDAO::getEventoById($b->getIdEvento())->getFecha());
					}

				$comp = compraDAO::getComprasByIdUser($_SESSION['id']);
				$i;
				$events;
				//Reordenamos los eventos por fechas
				usort($comp, "cmp");
				$cont = 0;
				foreach ($comp as $compra) {
					$evento = eventoDAO::getEventoById($compra->getIdEvento());
					$timestamp = strtotime($evento->getFecha());
					if($timestamp>=strtotime(date("Y/m/d"))){
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
									<p>'.$compra->getCantidad().' entradas '.tipoEntradaEventoDAO::getEntradaEventoByIdEvento($evento->getIdEvento(),$compra->getIdTipo())->getNombreParticular().'</p>
								</div>
							</a>
						</li>';
						$cont++;
					}
				}
				if($cont==0){
					echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>No participas en eventos actuales</h3></div></div></li>';
				}
				
			?>
			</ul>
		<a name="pasados"/>
		<h3 class="c2">Pasados</h3>
		<div class="linea"></div>
			<ul class="lista">
			<?php
			$cont = 0;
				foreach ($comp as $compra) {
					$evento = eventoDAO::getEventoById($compra->getIdEvento());
					$timestamp = strtotime($evento->getFecha());
					if($timestamp<strtotime(date("Y/m/d"))){
						$tipoStr = tipoEventoDAO::getTipoEventoStr($evento->getTipo());
						echo '<li class="celdaBusqueda">
							<a href="evento.php?eid='.$evento->getIdEvento().'">
								<div class="imgEvBusqueda"><img src="'.$evento->getRutaImagen().'"></div>
								<div class="infoEvBusqueda">
									<div class="titulo_evento"><h3>'.$evento->getNombreEvento().'</h3></div> 
									<span>'.$tipoStr.'</span>
									<p>'.strftime("%A, %d de %B de %Y", $timestamp).'</p>
									<p>'.$evento->getLugar().'</p>
									<p>'.$compra->getCantidad().' entradas '.tipoEntradaEventoDAO::getEntradaEventoByIdEvento($evento->getIdEvento(),$compra->getIdTipo())->getNombreParticular().'</p>
								</div>
							</a>
						</li>';
						$cont++;
					}
				}
				if($cont==0){
					echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>No tienes eventos pasados</h3></div></div></li>';
				}
			?>
			</ul>
		</div>
	</div>
</div>
<?php } else {	?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>