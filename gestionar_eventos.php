<?php include 'header.php';
include_once 'bd/tipoEventoDAO.php';
include_once 'class/tipoEvento.php';
include_once 'bd/eventoDAO.php';?>

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
			<div class="titulo_evento"><h2>Eventos Promovidos</h2></div>
			<a name="actuales"/></a>
			<h3 class="c2">Actuales</h3>
			<div class="linea"></div>
			<ul class="lista">
				<?php
				date_default_timezone_set('Europe/Madrid');
				$arr = eventoDAO::getEventosByPromotor($_SESSION['id']);
				$i;$cont=0;
				// $curr_date = date_default_timezone_get ();
				for($i = 0; $i < sizeof($arr); $i++){
					if(strtotime($arr[$i]->getFecha())>=strtotime(date("Y/m/d"))){
						echo '<li class="c3 prom"><a href="mod_evento.php?evento='.$arr[$i]->getIdEvento().'">'.$arr[$i]->getNombreEvento().'</a></li>';
						$cont++;
					}
				}
				if($cont==0){
					echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>No hay eventos actuales</h3></div></div></li>';
				}
				?>
			</ul>
			<a name="pasados"/>
			<h3 class="c2">Pasados</h3>
			<div class="linea"></div>
			<ul class="lista">
				<?php 
				$cont = 0;
				for($i = 0; $i < sizeof($arr); $i++){
					if(strtotime($arr[$i]->getFecha())<strtotime(date("Y/m/d"))){
						echo '<li class="c3 prom"><a href="mod_evento.php?evento='.$arr[$i]->getIdEvento().'">'.$arr[$i]->getNombreEvento().'</a></li>';
						$cont++;
					}
				}
				if($cont==0){
					echo '<li class="celdaBusqueda"><div class="noResults"><div class="titulo_evento"><h3>No hay eventos pasados</h3></div></div></li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>
<?php }else {?>
	<div class="page-wrapper">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>