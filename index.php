<?php include("header.php") ?>
<div id="contenido">
	<?php include("nav.php") ?>

	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12">
			<?php include('searchForm.php');?>
		</div>
		<!--Eventos destacados-->
			<div id="grid_conciertos">
<?php
	$num = 3;
	$events = eventoDAO::getEventosPrioritarios($num);
	$i;
	for($i = 1; $i <= sizeof($events); $i++){//TODO verificar para la descripcion del evento
		$text = $events[$i-1]->getDescripcion();
		$text2="";
		$comma = strpos($text,",");
		$full_stop = strpos($text, ".");
		if($comma == FALSE && $full_stop == FALSE)
			$text2 = substr($text, 0, 15);
		else if ($comma == FALSE)
			$text2 = substr($text, 0, $full_stop);
		else if($full_stop== FALSE)
			$text2 = substr($text, 0, $comma);
		else $text2 = substr($text, 0, min($comma, $full_stop));
		echo '<a href="evento.php?eid='.$events[$i-1]->getIdEvento().'"><div class="concierto" id="c'.$i.'"><img src="'.$events[$i-1]->getRutaImagen().'" alt="'.$events[$i-1]->getNombreEvento().'"/><div class="descripcion" id="d'.$i.'"><h4>'.$events[$i-1]->getNombreEvento().'</h4><p>'.$text2.'</p></div></div></a>';
	}
?>
			</div>
	</div>
</div>

<script type="text/javascript" src="scripts/efectosIndex.js"></script>
<?php include("footer.html") ?>